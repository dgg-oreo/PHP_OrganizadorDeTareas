<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('/', 'Home::index');
$routes->get('lang/(:segment)', 'Lang::set/$1');