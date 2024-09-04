<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// CRUD
$routes->get('/view', 'CRUDController::index');

$routes->get('/tambah', 'CRUDController::create');
$routes->post('/menambahkan', 'CRUDController::store');

$routes->get('/edit/(:num)', 'CRUDController::edit/$1');
$routes->post('/mengupdate/(:num)', 'CRUDController::update/$1');

$routes->get('/delete/(:num)', 'CRUDController::delete/$1');

$routes->get('image/crop', 'ImageController::cropImage');

$routes->get('peserta', 'CRUDController::cropindex');


$routes->get('/login', 'LoginController::index');

