<?php

/**
 * Here you can register your own API routes
 *
 * API Routes can be a callable function:
 * $router->api('users', function () { ... });
 *
 * or can also be handled by a Controller.
 * $router->api('users', 'ApiController@users');
 */

$router = new \Flamingo\Http\Router;

$router->api('tasks', function () {
    $tasks = \App\Models\Task::all();
    return apiView($tasks);
});