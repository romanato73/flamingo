<?php

/**
 * Here you can register your own WEB routes
 *
 * WEB Routes can be a callable function:
 * $router->method(string uri, callable() function);
 *
 * or can also be handled by a Controller.
 * $router->method(string uri, 'Controller@method');
 *
 * Available methods:
 * get, post, put, delete
 */

$router = new \Flamingo\Http\Router;

$router->get('', function() {
    return view('welcome');
});

$router->resource('tasks', 'TaskController');