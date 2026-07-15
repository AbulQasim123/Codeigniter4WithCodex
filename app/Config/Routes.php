<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Store::index');
$routes->get('cart', 'Store::cart');
$routes->post('cart/add/(:num)', 'Store::addCart/$1');
$routes->post('cart/update/(:num)', 'Store::updateCart/$1');
$routes->get('checkout', 'Store::checkout');
$routes->post('checkout', 'Store::placeOrder');
$routes->get('order/(:segment)', 'Store::order/$1');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::create');
$routes->post('logout', 'Auth::logout');
$routes->post('admin/logout', 'Auth::adminLogout');
$routes->get('profile', 'Auth::profile');
$routes->post('profile', 'Auth::profileUpdate');
$routes->post('profile/password', 'Auth::passwordUpdate');
$routes->get('admin/register', 'AdminSetup::register');
$routes->post('admin/register', 'AdminSetup::create');

$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('', 'Admin::dashboard');
    $routes->get('products', 'Admin::products');
    $routes->post('products', 'Admin::productSave');
    $routes->delete('products/(:num)', 'Admin::productDelete/$1');
    $routes->get('categories', 'Admin::categories');
    $routes->post('categories', 'Admin::categorySave');
    $routes->delete('categories/(:num)', 'Admin::categoryDelete/$1');
    $routes->get('orders', 'Admin::orders');
    $routes->post('orders/(:num)', 'Admin::status/$1');
    $routes->get('users', 'Admin::users');
    $routes->post('users/(:num)/block', 'Admin::userBlock/$1');
    $routes->get('logs', 'Admin::logs');
});


$routes->group('api/v1', static function ($routes) {
    $routes->get('products', 'Api\\V1::products');
    $routes->post('auth/register', 'Api\\V1::register');
    $routes->post('auth/login', 'Api\\V1::login');
    $routes->get('cart', 'Api\\V1::cart');
    $routes->post('cart/items', 'Api\\V1::addCart');
    $routes->put('cart/items/(:num)', 'Api\\V1::updateCart/$1');
    $routes->post('checkout', 'Api\\V1::checkout');
    $routes->get('orders', 'Api\\V1::orders');
});
