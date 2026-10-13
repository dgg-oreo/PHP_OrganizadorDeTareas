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
}