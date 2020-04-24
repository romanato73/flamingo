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

$router->get('', function() {
    return view('index');
});

$router->get('about', function() {
    return view('about');
});

$router->get('messages', 'MessageController@index');
$router->post('messages', 'MessageController@store');

$router->get('tasks', 'TaskController@index');

$router->get('users', function () {
    $users = \App\Models\User::all();

    return view('users', ['users' => $users]);
});

$router->get('auth/login', 'AuthController@login');
$router->get('auth/register', 'AuthController@register');