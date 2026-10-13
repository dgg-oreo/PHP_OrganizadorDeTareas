<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('/', 'Home::index');
$routes->get('lang/(:segment)', 'Lang::set/$1');

$routes->get('signup', 'Auth::signup');
$routes->post('signup', 'Auth::register');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');