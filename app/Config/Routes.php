<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/login', 'AuthController::processLogin');
$routes->post('/register', 'AuthController::processRegister');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/task/create', 'TaskController::create');
$routes->post('/task/store', 'TaskController::store');
$routes->get('/task/edit/(:num)', 'TaskController::edit/$1');
$routes->post('/task/update/(:num)', 'TaskController::update/$1');
$routes->get('/profile', 'UserController::profile');
$routes->post('/profile/update', 'UserController::updateProfile');

