<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('dashboard');
$routes->setDefaultMethod('');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index');

$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/login', 'Login::index');
$routes->post('/login/process', 'Login::process');
$routes->get('/logout', 'Login::logout');

$routes->get('/register', 'Register::index');
$routes->post('/register/process', 'Register::process');

$routes->get('/register', 'Register::index');
$routes->post('/register/process', 'Register::process');

$routes->get('/perusahaan', 'Perusahaan::index');
$routes->get('/perusahaan/create', 'Perusahaan::create');
$routes->get('/perusahaan/edit/(:segment)', 'Perusahaan::edit/$1');
$routes->delete('/perusahaan/delete/(:segment)', 'Perusahaan::delete/$1');
$routes->get('/perusahaan/delete/(:any)', 'Perusahaan::restrict'); //Mencegah user delete melalui GET URL
$routes->get('/perusahaan/(:any)', 'Perusahaan::restrict'); //Mencegah user masuk menu yang tidak tersedia

$routes->get('/mesinfotocopy', 'MesinFotocopy::index');
$routes->get('/mesinfotocopy/create', 'MesinFotocopy::create');
$routes->get('/mesinfotocopy/edit/(:segment)', 'MesinFotocopy::edit/$1');
$routes->delete('/mesinfotocopy/delete/(:segment)', 'MesinFotocopy::delete/$1');
$routes->get('/mesinfotocopy/delete/(:any)', 'MesinFotocopy::restrict'); //Mencegah user delete melalui GET URL
$routes->get('/mesinfotocopy/(:any)', 'MesinFotocopy::restrict'); //Mencegah user masuk menu yang tidak tersedia

$routes->get('/persewaandetail/create/(:segment)', 'PersewaanDetail::create/$1');
$routes->get('/persewaandetail/(:segment)', 'PersewaanDetail::index/$1');
$routes->get('/persewaandetail/edit/(:segment)/(:segment)', 'PersewaanDetail::edit/$1/$1');
$routes->delete('/persewaandetail/delete/(:segment)', 'PersewaanDetail::delete/$1');
$routes->get('/persewaandetail/delete/(:any)', 'PersewaanDetail::restrict'); //Mencegah user delete melalui GET URL
$routes->get('/persewaandetail/(:any)', 'PersewaanDetail::restrict'); //Mencegah user masuk menu yang tidak tersedia

$routes->get('/peramalan', 'Peramalan::index');
$routes->get('/peramalan/delete/(:any)', 'Peramalan::restrict'); //Mencegah user delete melalui GET URL
$routes->get('/peramalan/(:any)', 'Peramalan::restrict'); //Mencegah user masuk menu yang tidak tersedia
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
