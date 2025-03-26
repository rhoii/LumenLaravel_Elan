<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Unsecured Routes
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', 'UserController@index'); // Get all users
    $router->get('/users/{id}', 'UserController@show'); // Get user by ID
    $router->post('/users', 'UserController@add'); // Create a new user
    $router->put('/users/{id}', 'UserController@update'); // Update user
    $router->patch('/users/{id}', 'UserController@update'); // Partial update
    $router->delete('/users/{id}', 'UserController@delete'); // Delete user
});

// New Unsecured Routes without /api prefix (new addition)
$router->group([], function () use ($router) {
    $router->get('/users', 'UserController@index'); // Get all users (http://localhost:8000/users)
    $router->get('/users/{id}', 'UserController@show'); // Get user by ID (http://localhost:8000/users/{id})
    $router->post('/users', 'UserController@add'); // Create a new user
    $router->put('/users/{id}', 'UserController@update'); // Update user
    $router->patch('/users/{id}', 'UserController@update'); // Partial user update
    $router->delete('/users/{id}', 'UserController@delete'); // Delete user
});
