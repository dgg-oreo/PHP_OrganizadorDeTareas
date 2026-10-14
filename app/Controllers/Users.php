<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    protected $helpers = ['form'];

    private function findOr404(int $id): array
    {
        $user = (new UserModel())->find($id);
        if (! $user) {
            throw PageNotFoundException::forPageNotFound();
        }
        return $user;
    }

    private function isSelf(int $id): bool
    {
        return $id === (int) session()->get('user_id');
    }

    private function formView(array $data)
    {
        return view('users/form', $data);
    }


    public function index()
    {
        $model = new UserModel();
        $users = $model->orderBy('created_at', 'DESC')
                       ->orderBy('id', 'DESC')
                       ->paginate(10);

        return view('users/index', [
            'users' => $users,
            'pager' => $model->pager,
        ]);
    }


    public function show(int $id)
    {
        return view('users/show', [
            'user'   => $this->findOr404($id),
            'isSelf' => $this->isSelf($id),
        ]);
    }

    public function create()
    {
        return $this->formView([
            'title'  => lang('Users.new_title'),
            'action' => base_url('users/new'),
            'user'   => null,
            'isSelf' => false,
        ]);
    }

    public function store()
    {
        $rules = [
            'name'             => 'required|trim|min_length[3]|max_length[100]',
            'email'            => 'required|trim|valid_email|max_length[150]|is_unique[users.email]',
            'password'         => 'required|min_length[8]|max_length[72]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return $this->formView([
                'title'  => lang('Users.new_title'),
                'action' => base_url('users/new'),
                'user'   => null,
                'isSelf' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        (new UserModel())->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => strtolower($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'   => 1,
            'is_admin' => 0, 
        ]);

        return redirect()->to('users')->with('success', lang('Users.created'));
    }

    public function edit(int $id)
    {
        return $this->formView([
            'title'  => lang('Users.edit_title'),
            'action' => base_url("users/{$id}/edit"),
            'user'   => $this->findOr404($id),
            'isSelf' => $this->isSelf($id),
        ]);
    }

    public function update(int $id)
    {
        $user   = $this->findOr404($id);
        $isSelf = $this->isSelf($id);

        $rules = [
            'name'     => 'required|trim|min_length[3]|max_length[100]',
            'email'    => "required|trim|valid_email|max_length[150]|is_unique[users.email,id,{$id}]",
            'password' => 'permit_empty|min_length[8]|max_length[72]',
        ];

        $errors   = [];
        $password = (string) $this->request->getPost('password');

        if (! $this->validate($rules)) {
            $errors = $this->validator->getErrors();
        } elseif ($password !== '' && $password !== (string) $this->request->getPost('password_confirm')) {
            $errors = [lang('Users.passwords_mismatch')];
        }

        if ($errors) {
            return $this->formView([
                'title'  => lang('Users.edit_title'),
                'action' => base_url("users/{$id}/edit"),
                'user'   => $user,
                'isSelf' => $isSelf,
                'errors' => $errors,
            ]);
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => strtolower($this->request->getPost('email')),
        ];


        if ($password !== '') {
            $data['password']       = password_hash($password, PASSWORD_DEFAULT);
            $data['remember_token'] = null;
        }

        if (! $isSelf) {
            $data['active']   = $this->request->getPost('active') ? 1 : 0;
            $data['is_admin'] = $this->request->getPost('is_admin') ? 1 : 0;

            if ($data['active'] === 0) {
                $data['remember_token'] = null;
            }
        }

        (new UserModel())->update($id, $data);

        if ($isSelf) {
            session()->set('user_name', $data['name']);
        }

        return redirect()->to("users/{$id}")->with('success', lang('Users.updated'));
    }

    public function delete(int $id)
    {
        $user = $this->findOr404($id);

        if ($this->isSelf($id)) {
            return redirect()->to("users/{$id}")->with('error', lang('Users.cannot_delete_self'));
        }

        if (! empty($user['avatar'])) {
            $path = FCPATH . 'uploads/avatars/' . basename($user['avatar']);
            if (is_file($path)) {
                unlink($path);
            }
        }

        (new UserModel())->delete($id);

        return redirect()->to('users')->with('success', lang('Users.deleted'));
    }
}