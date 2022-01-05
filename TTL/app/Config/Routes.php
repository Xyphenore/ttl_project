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
 * gestion par UserSController
 */
$routes->match(['get', 'post'], 'register',         'UsersController::register');
$routes->match(['get', 'post'], 'login',            'UsersController::login');
$routes->match(['get', 'post'], 'logout',           'UsersController::logout');
$routes->match(['get', 'post'], 'deconnexion',      'UsersController::logout');
$routes->match(['get', 'post'], 'DECONNEXION',      'UsersController::logout');
$routes->match(['get', 'post'], 'dashboard/action', 'UsersController::actionDashboard');
$routes->match(['get', 'post'], 'UserSetting',      'UsersController::usersetting');
$routes->match(['get', 'post'], 'UserDelete',       'UsersController::userdelete');
$routes->match(['get', 'post'], 'dashboard',        'UsersController::dashboard');

$routes->get('dashboard',           'UsersController::dashboard');

$routes->get('users/(:segment)',    'UsersController::view/$1');
$routes->get('users',               'UsersController::index');

// Partie de l'administrateur
$routes->match(['get', 'post'], 'adminDashboard',        'AdminController::adminDashboard');
$routes->match(['get', 'post'], 'adminUserAction', 'AdminController::adminUserAction');
$routes->get('adminDashboard',      'AdminController::adminDashboard');
$routes->get('adminAdsManager',      'AdminController::adminAdsManager');
$routes->get('adminUserManager',      'AdminController::adminUserManager');

$routes->match(['get', 'post'], 'adminAdAction', 'AdminController::adminAdAction');
$routes->match(['get', 'post'], 'adminMsgAction', 'AdminController::adminAdAction');

/**
 * Gestion par AdsController
 */
$routes->match(['get', 'post'], 'createAds',        'AdsController::createAds');
$routes->match(['get', 'post'], 'actionAds',        'AdsController::actionAds');
$routes->match(['get', 'post'], 'updateAds',        'AdsController::updateAds');


// $routes->get('createAds',             'AdsController::createAds');
$routes->get('ads/userAds',         'AdsController::privateView/$1');
$routes->get('userAds',             'AdsController::privateView/$1');

$routes->get('allAds',              'AdsController::globalView');
$routes->get('updateAds',           'AdsController::updateAds');
$routes->get('index',               'AdsController::index');
$routes->get('privateAds',          'AdsController::privateView');
$routes->get('detail',              'AdsController::detailView/$1');
$routes->get('ads/(:segment)',      'AdsController::detailView/$1');
$routes->get('ads',                 'AdsController::index');

/**
 * Gestion par MessageController
 */
$routes->match(['get', 'post'],'actionMessage',       'MessageController::actionMessage');
$routes->match(['get', 'post'],'contact',               'MessageController::contact');
$routes->match(['get', 'post'],'messages',               'MessageController::viewMessages');
$routes->get('adsMessages',            'MessageController::viewMessages');
$routes->get('adsMessages/(:segment)',      'MessageController::View/$1');

 /**
 * Gestion par PhotoController
 */
$routes->get('photos/adsPhoto',     'PhotoController::privateView/$1');
$routes->get('photos/(:segment)',   'PhotoController::view/$1');
$routes->get('photos',              'PhotoController::index');

/**
 * Gestion par PageController
 */
// $routes->get('pages/(:segment)',    'PagesController::view/$1');
// $routes->get('pages',               'PagesController::index');

// Redirections pour les pages annexes (CGU, COOKIES, REGLES_DIFFUSION)
// $routes->get('CGU',                 'PagesController::view/cgu');
// $routes->get('COOKIES',             'PagesController::view/cookies');
// $routes->get('REGLES_DIFFUSION',    'PagesController::view/regles_diffusion');
// $routes->get('regle_diffusion',     'PagesController::view/regles_diffusion');
// $routes->get('REGLE_DIFFUSION',     'PagesController::view/regles_diffusion');

$routes->get('cgu',                 'PagesController::cgu');
$routes->get('reglesDiffusion',     'PagesController::reglesDiffusion');
$routes->get('cookies',             'PagesController::cookies');


$routes->get('/',                   'AdsController::index');
$routes->get('(:any)',              'PagesController::view/$1');



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
