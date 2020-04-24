<?php

/**
 * Return a view.
 *
 * @param string $name
 * @param array $data
 * @return mixed
 */
function view($name, $data = [])
{
    extract($data);

    return require "../app/Views/{$name}.php";
}

/**
 * Redirect to a specified path.
 *
 * @param  string $path
 */
function redirect($path)
{
    header("Location: /{$path}");
}

/**
 * Route simplifier for forms.
 *
 * @param string $route
 * @return string
 */
function route($route) {
    $route = explode('.', $route);
    $route = implode('/', $route);
    $route = substr_replace($route, '/', 0, 0);
    return htmlspecialchars($route);
}

/**
 * Setup API Route
 *
 * @param \Illuminate\Database\Eloquent\Collection $route
 * @return string|true
 */
function apiView(\Illuminate\Database\Eloquent\Collection $route) {
    header('Content-Type: application/json');
    return print_r($route->toJson());
}

/**
 * Generate form's important fields
 *
 * @param string $method
 * @param bool $csrf
 */
function form($method, $csrf = true) {
    echo "<input type='hidden' name='_method' value='{$method}'>";
    if ($csrf) {
        echo "<input type='hidden' name='_csrf' value='{$_SESSION['csrf']}'>";
    }
}

/**
 * Clears the input data.
 *
 * @param $input
 * @return string
 */
function inputData($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}