<?php

/**
 * Flamingo - A Simple PHP MVC Framework.
 *
 * @package flamingo
 * @author Roman Orszagh <romikor1999@gmail.com>
 */

define('FLAMINGO_START', microtime(true));

/**
 * Register The Auto Loader
 */

require __DIR__ . '/../vendor/autoload.php';

/**
 * Make Flamingo Fly
 */
require __DIR__ . '/../app/fly.php';
