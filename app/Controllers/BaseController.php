<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @param CLIRequest|IncomingRequest $request
     *
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {

        parent::initController($request, $response, $logger);

    $locale = session()->get('lang');
    if ($locale) {
        service('request')->setLocale($locale);
    }

    if (! session()->get('logged_in')) {
            $cookie = $this->request->getCookie('remember');

            if ($cookie && str_contains($cookie, ':')) {
                [$id, $token] = explode(':', $cookie, 2);
                $user = (new \App\Models\UserModel())->find((int) $id);

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
        }

}
    }
