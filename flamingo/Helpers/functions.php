<?php

use Flamingo\Exception\HttpException;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('view')) {
    /**
     * Return a view.
     *
     * @param string $name
     * @param array $data
     * @return mixed
     */
    function view(string $name, $data = [])
    {
        try {
            // Check for file
            if (!file_exists(VIEWS_DIR . "/{$name}.php")) {
                throw new HttpException("View <b>{$name}</b> does not exists.");
            }
            // Extract data and return a view file
            extract($data);
            return require VIEWS_DIR . "/{$name}.php";
        } catch (HttpException $exception) {
            die($exception->text());
        }
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a specified path.
     *
     * @param string $path
     */
    function redirect(string $path)
    {
        header("Location: /{$path}");
    }
}

if (!function_exists('apiView')) {
    /**
     * Setup API Route
     *
     * @param Collection $route
     * @return string|true
     */
    function apiView(Collection $route)
    {
        header('Content-Type: application/json');
        return print_r($route->toJson());
    }
}

if (!function_exists('form')) {
    /**
     * Generate form's important fields
     *
     * @param string $method
     * @param bool $csrf
     */
    function form(string $method, $csrf = true) {
        echo "<input type='hidden' name='_method' value='{$method}'>";
        if ($csrf) {
            echo "<input type='hidden' name='_csrf' value='{$_SESSION['csrf']}'>";
        }
    }
}

if (!function_exists('validate')) {
    /**
     * Clears the input data.
     *
     * @param $input
     * @return string
     */
    function validate($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}

if (!function_exists('route')) {
    /**
     * Route simplifier.
     *
     * @param string $route
     * @return string
     */
    function route(string $route) {
        // Get global variable
        global $__projectPath;

        // Validate route
        $route = validate($route);

        // Check for global project path
        if (isset($__projectPath)) {
            return '/' . $__projectPath . '/' . $route;
        }

        // Return route
        return '/' . $route;
    }
}

if (!function_exists('request')) {
    /**
     * Returns collected post items.
     *
     * @param mixed $name
     * @param bool $isset
     * @return bool|string
     */
    function request($name, bool $isset = false) {
        // Protected items
        $protected = ['_method', '_csrf'];

        // Checks for protected items
        if (in_array($name, $protected)) {
            return false;
        }

        // Check if item has been posted
        if (!in_array($name, array_keys($_POST))) {
            return false;
        }

        // Return validated item
        return $isset ? isset($_POST[$name]) : (is_string($name) ? validate($_POST[$name]) : $name);
    }
}