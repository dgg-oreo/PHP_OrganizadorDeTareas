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

$routes->group('profile', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Profile::index');
    $routes->get('confirm', 'Profile::confirm');
    $routes->post('confirm', 'Profile::confirmPost');
    $routes->get('edit', 'Profile::edit');
    $routes->post('edit', 'Profile::update');
    $routes->get('password', 'Profile::password');
    $routes->post('password', 'Profile::updatePassword');
    $routes->get('image', 'Profile::image');
    $routes->post('image', 'Profile::updateImage');
    $routes->get('image/delete', 'Profile::deleteImage');
    $routes->post('image/delete', 'Profile::destroyImage');
});