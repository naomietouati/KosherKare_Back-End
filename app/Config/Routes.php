<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/user/connection', 'user::connection');
$routes->post('/user/registration', 'user::registration');
$routes->post('/meal/MealGeneration', 'meal::MealGeneration');

/*
$routes->group("api", function ($routes) {
    $routes->post("register", "Register::index");
    $routes->post("login", "Login::index");
    $routes->get("users", "User::index", ['filter' => 'authFilter']);
});
*/