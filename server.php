<?php

/**
 * Flamingo - A Simple PHP MVC Framework.
 *
 * @package flamingo
 * @author Roman Orszagh <romikor1999@gmail.com>
 */

$uri = trim(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
);

/**
 * This file allows to emulate Apache's "mod_rewrite"
 * functionality in case the public directory has not
 * been set as the DOCUMENT ROOT.
 */

$__projectPath = basename(__DIR__);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';