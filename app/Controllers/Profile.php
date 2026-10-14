<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    private function me(): array
    {
        $user = (new UserModel())->find((int) session()->get('user_id'));
        if (! $user) {
            session()->destroy();
            header('Location: ' . base_url('login'));
            exit;
        }
        return $user;
    }

    // Confirmacion cada 5 min
    private function reauthOk(): bool
    {
        return (int) session()->get('reauth_until') > time();
    }

    private function avatarDir(): string
    {
        return FCPATH . 'uploads/avatars/';
    }

    private function removeAvatarFile(?string $file): void
    {
        if ($file) {
            $path = $this->avatarDir() . basename($file);
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    // List
    public function index()
    {
        return view('profile/index', ['user' => $this->me()]);
    }

    // Corroborar contra
    public function confirm()
    {
        helper('form');
        return view('profile/confirm');
    }

    public function confirmPost()
    {
        helper('form');

        if (! $this->validate(['password' => 'required'])) {
            return view('profile/confirm', ['errors' => $this->validator->getErrors()]);
        }

        if (! password_verify($this->request->getPost('password'), $this->me()['password'])) {
            return view('profile/confirm', ['errors' => [lang('Profile.wrong_password')]]);
        }

        session()->set('reauth_until', time() + 300);
        return redirect()->to('profile/edit');
    }

    // Editar nombre y correo
    public function edit()
    {
        if (! $this->reauthOk()) {
            return redirect()->to('profile/confirm');
        }
        helper('form');
        return view('profile/edit', ['user' => $this->me()]);
    }

    public function update()
    {
        if (! $this->reauthOk()) {
            return redirect()->to('profile/confirm');
        }
        helper('form');

        $id    = (int) session()->get('user_id');
        $rules = [
            'name'  => 'required|trim|min_length[3]|max_length[100]',
            'email' => "required|trim|valid_email|max_length[150]|is_unique[users.email,id,{$id}]",
        ];

        if (! $this->validate($rules)) {
            return view('profile/edit', ['user' => $this->me(), 'errors' => $this->validator->getErrors()]);
        }

        $name = $this->request->getPost('name');
        (new UserModel())->update($id, [
            'name'  => $name,
            'email' => strtolower($this->request->getPost('email')),
        ]);
        session()->set('user_name', $name);

        return redirect()->to('profile')->with('success', lang('Profile.updated'));
    }

    // Csambiar comtra

    public function password()
    {
        helper('form');
        return view('profile/password');
    }

    public function updatePassword()
    {
        helper('form');

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]|max_length[72]',
            'new_confirm'      => 'required|matches[new_password]',
        ];

        if (! $this->validate($rules)) {
            return view('profile/password', ['errors' => $this->validator->getErrors()]);
        }

        $user = $this->me();
        if (! password_verify($this->request->getPost('current_password'), $user['password'])) {
            return view('profile/password', ['errors' => [lang('Profile.wrong_password')]]);
        }

        (new UserModel())->update($user['id'], [
            'password'       => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
            'remember_token' => null,
        ]);

        return redirect()->to('profile')->with('success', lang('Profile.password_updated'));
    }

    // Cambiar foto de perfil

    public function image()
    {
        helper('form');
        return view('profile/image');
    }

    public function updateImage()
    {
        helper('form');

        $rules = [
            'avatar' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return view('profile/image', ['errors' => $this->validator->getErrors()]);
        }

        $file = $this->request->getFile('avatar');
        $user = $this->me();

        $name = $file->getRandomName();
        $file->move($this->avatarDir(), $name);

        $this->removeAvatarFile($user['avatar']);
        (new UserModel())->update($user['id'], ['avatar' => $name]);

        return redirect()->to('profile')->with('success', lang('Profile.image_updated'));
    }

    // borrar pfp

    public function deleteImage()
    {
        helper('form');
        return view('profile/delete_image');
    }

    public function destroyImage()
    {
        $user = $this->me();
        $this->removeAvatarFile($user['avatar']);
        (new UserModel())->update($user['id'], ['avatar' => null]);

        return redirect()->to('profile')->with('success', lang('Profile.image_deleted'));
    }
}