<?php

use Flamingo\Kernel\{App, Helpers};
use Flamingo\Http\{Router, Request};

/**
 * Load helpers.
 *
 * Helpers are collection of functions,
 * which helps you to develop faster,
 * more effective and secure.
 */
Helpers::load(__DIR__ . '/../flamingo/Helpers/');

/**
 * Load configs into the app container.
 *
 * App container is an registry of configs,
 * which can be used in development.
 * Every config has the name same as the file.
 * You can use it by calling an App instance:
 * App::get(name)
 */
App::configs(__DIR__ . '/../config/');

/**
 * Initialize App
 *
 * Initializes all important functions for
 * your app.
 */
App::init();

/**
 * Load routes
 *
 * All routes can be configured inside routes
 * directory. It basically attach all registered
 * routes inside Router register.
 *
 * After loading a routes get uri and find if
 * that matches with co-responding controller
 * and method inside routes registry.
 */
Router::load(__DIR__ . '/../routes/')
    ->direct(Request::uri(), Request::method());