<?php


namespace Flamingo\Http;


class Request
{
    /**
     * Fetch the request URI.
     *
     * @return string
     */
    public static function uri()
    {
        global $__projectPath;

        // Get URI
        $uri = trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );

        // Check if it's not running from server.php
        if (isset($__projectPath)) {
            if (strpos($uri, $__projectPath) !== false) {
                // Fix URI and remove project directory name
                $uri = str_replace($__projectPath, '', $uri);
                $uri = trim(
                    parse_url($uri, PHP_URL_PATH), '/'
                );
            }
        }

        // Return URI
        return $uri;
    }

    /**
     * Fetch the request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}