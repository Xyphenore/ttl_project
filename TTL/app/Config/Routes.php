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


/**
 * Routes pour les utilisateurs
 */
$routes->match(['get', 'post'], 'register', 'UsersController::register');
$routes->match(['get', 'post'], 'loggin', 'UsersController::loggin');
$routes->match(['get', 'post'], 'logout', 'UsersController::logout');

// lorsqu'un bouton est cliqué sur le dashboard
$routes->match(['get', 'post'], 'dashboard/action', 'UsersController::actionDashboard');

$routes->match(['get', 'post'], 'setting_user', 'UsersController::setting_user');
$routes->match(['get', 'post'], 'dashboard', 'UsersController::dashboard');

$routes->get('dashboard', 'UsersController::dashboard');
$routes->get('users/(:segment)', 'UsersController::view/$1');
$routes->get('users', 'UsersController::index');

/**
 * Routes pour les annonces
 */
$routes->match(['get', 'post'], 'ads/create', 'AdsController::createAds');
$routes->match(['get', 'post'], 'ads/action', 'AdsController::actionAds');
$routes->match(['get', 'post'], 'ads/update', 'AdsController::updateAds');

// route pour contacter un propriétaire
$routes->match(['get', 'post'], 'contact', 'MessageController::contact');
$routes->get('allMessages', 'MessageController::viewAdsMessages');


$routes->get('ads/userAds', 'AdsController::privateView/$1');
$routes->get('allAds', 'AdsController::globalView');

$routes->get('userAds', 'AdsController::privateView/$1');
$routes->get('index', 'AdsController::index');
$routes->get('allAds', 'AdsController::globalView');
$routes->get('privateAds', 'AdsController::privateView');
$routes->get('detail', 'AdsController::detailView/$1');


$routes->get('ads/(:segment)', 'AdsController::detailView/$1');
$routes->get('ads', 'AdsController::index');


/**
 * Routes pour les photo
 */
$routes->get('photos/adsPhoto', 'PhotoController::privateView/$1');
$routes->get('photos/(:segment)', 'PhotoController::view/$1');
$routes->get('photos', 'PhotoController::index');

// This makes sure the requests reach the UsersController 
// instead of going directly to the PagesController


$routes->get('privates/(:segment)', 'PrivateController::view/$1');
$routes->get('privates', 'PrivateController::index');

$routes->get('pages/(:segment)', 'PagesController::view/$1');
$routes->get('pages', 'PagesController::index');

// Redirections deconnexion
$routes->match(['get', 'post'], 'deconnexion', 'UsersController::logout');
$routes->match(['get', 'post'], 'DECONNEXION', 'UsersController::logout');


// Redirections pour les pages annexes (CGU, COOKIES, REGLES_DIFFUSION)
$routes->get('CGU', 'PagesController::view/cgu');
$routes->get('COOKIES', 'PagesController::view/cookies');
$routes->get('REGLES_DIFFUSION', 'PagesController::view/regles_diffusion');
$routes->get('regle_diffusion', 'PagesController::view/regles_diffusion');
$routes->get('REGLE_DIFFUSION', 'PagesController::view/regles_diffusion');

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
