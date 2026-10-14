<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class InitFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $locale = session()->get('lang');
        if ($locale) {
            service('request')->setLocale($locale);
        }

        if (session()->get('logged_in')) {
            return;
        }

        $cookie = service('request')->getCookie('remember');
        if (! $cookie || ! str_contains($cookie, ':')) {
            return;
        }

        [$id, $token] = explode(':', $cookie, 2);
        $user = (new UserModel())->find((int) $id);

        if ($user
            && (int) $user['active'] === 1
            && ! empty($user['remember_token'])
            && hash_equals($user['remember_token'], hash('sha256', $token))
        ) {
            session()->set([
                'logged_in' => true,
                'user_id'   => $user['id'],
                'user_name' => $user['name'],
                'is_admin'  => (int) $user['is_admin'],
            ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}