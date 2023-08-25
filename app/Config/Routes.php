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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
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
$routes->get('/', 'Home::index');

//Super Admin Panel Routes
$routes->get('/super-admin-login', 'super_admin/Auth::login');
$routes->get('/super-admin-dashboard', 'super_admin/Home::dashboard');
$routes->get('/super-admin-logout', 'super_admin/Home::logout');
$routes->get('/super-admin-restaurant', 'super_admin/Restaurant::restaurantManagement');
$routes->get('/super-admin-restaurant-list', 'super_admin/Restaurant::restaurantList');
$routes->get('/super-admin-product-list', 'super_admin/Product::productList');
$routes->get('/super-admin-user-list', 'super_admin/User::userList');
$routes->get('/categories-list', 'super_admin/Category::categoryList');
$routes->add('/report/(:any)', 'super_admin\Report::dailyReport/$1');
$routes->get('/get_items', 'super_admin/Report::get_items');
// $routes->get('/item', 'super_admin/Report::index');
//$routes->post('/super-admin-restaurant-setup', 'super_admin/Restaurant::setupRestaurant');
//$routes->get('/super-admin-login-submit', 'super_admin/Auth::authenticationCheck');
//End Super Admin Panel Routes

//Admin Panel routes
$routes->get('/user-dashboard', 'admin/Home::dashboard');
$routes->get('/orders', 'admin/Order::makeOrder');
$routes->get('/quick-orders', 'admin/Order::makeQuickOrder');
$routes->add('/print-kot-orders/(:any)', 'admin\Order::printKotOrder/$1');

//End Admin panel routes
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
