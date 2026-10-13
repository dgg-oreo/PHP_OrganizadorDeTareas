<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{

    public function signup()
    {
        helper('form');
        return view('signup');
    }


    public function register()
    {
        helper('form');

        $rules = [
            'name' => 'required|trim|min_length[3]|max_length[100]',
            'email' => 'required|trim|valid_email|max_length[150]|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[72]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {

            return view('signup', ['errors' => $this->validator->getErrors()]);
        }

        $model = new UserModel();
        $model->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => strtolower($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'   => 1,  
            'is_admin' => 0,  
        ]);

        return redirect()->to('/')->with('success', lang('Auth.signup_success'));
    }


    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        helper('form');
        return view('login');
    }

    public function attempt()
    {
        helper('form');

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('login', ['errors' => $this->validator->getErrors()]);
        }

        $email = strtolower(trim($this->request->getPost('email')));
        $model = new UserModel();
        $user  = $model->where('email', $email)->first();

        if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
            return view('login', ['errors' => [lang('Auth.invalid_credentials')]]);
        }

        if ((int) $user['active'] !== 1) {
            return view('login', ['errors' => [lang('Auth.inactive_account')]]);
        }

        session()->regenerate();
        session()->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'is_admin'  => (int) $user['is_admin'],
        ]);

        $redirect = redirect()->to('/')->with('success', lang('App.login_success'));

        if ($this->request->getPost('remember')) {
            $token = bin2hex(random_bytes(32));
            $model->update($user['id'], ['remember_token' => hash('sha256', $token)]);

            $this->response->setCookie([
                'name'     => 'remember',
                'value'    => $user['id'] . ':' . $token,
                'expire'   => 60 * 60 * 24 * 30,  
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            $redirect->withCookies();
        }

        return $redirect;
    }

    public function logout()
    {
        $id = session()->get('user_id');
        if ($id) {
            (new UserModel())->update($id, ['remember_token' => null]);
        }

        session()->remove(['logged_in', 'user_id', 'user_name', 'is_admin']);
        $this->response->deleteCookie('remember');

        return redirect()->to('/')
            ->with('success', lang('App.logout_success'))
            ->withCookies();
    }
}