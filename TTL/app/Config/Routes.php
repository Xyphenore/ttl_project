<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('PagesController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// any incoming request without any content specified 
// should be handled by the index() method inside the Home controller.


$routes->match(['get', 'post'], 'forms/register', 'UsersController::register');
$routes->match(['get', 'post'], 'forms/loggin', 'UsersController::loggin');
// This makes sure the requests reach the UsersController
// instead of going directly to the PagesController
$routes->get('users/(:segment)', 'UsersController::view/$1');
$routes->get('users', 'UsersController::index');

$routes->get('privates/(:segment)', 'PrivateController::view/$1');
$routes->get('privates', 'PrivateController::index');

$routes->get('pages/(:segment)', 'PagesController::view/$1');
$routes->get('pages', 'PagesController::index');

// Here, the second rule in the $routes object matches any request
// using the wildcard string (:any). and passes the parameter to
// the view() method of the Pages class.
$routes->get('/', 'PagesController::view/index');
$routes->get('(:any)', 'PagesController::view/$1');



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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
