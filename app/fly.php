<?php

use Flamingo\Kernel\App;
use Flamingo\Kernel\{Helpers, Router, Request};
use Illuminate\Database\Capsule\Manager as Capsule;

/** Load Helpers */
Helpers::load(__DIR__ . '/../flamingo/Helpers/');

/** Load config folder into app container */
App::configs(ROOT . '/config/');

/** New capsule instance */
$capsule = new Capsule();

/** Create connection */
$capsule->addConnection([
    'driver' => App::get('database')['driver'],
    'host' => App::get('database')['host'],
    'username' => App::get('database')['user'],
    'password' => App::get('database')['password'],
    'database' => App::get('database')['database'],
    'charset' => App::get('database')['charset'],
    'collation' => App::get('database')['collation'],
    'prefix' => App::get('database')['prefix']
]);

/** Boot eloquent */
$capsule->bootEloquent();

/** Load routes */
Router::load(ROOT . '/routes/')
    ->direct(Request::uri(), Request::method());