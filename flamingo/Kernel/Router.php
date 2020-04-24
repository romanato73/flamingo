<?php


namespace Flamingo\Kernel;


use Flamingo\Exception\HttpException;

class Router
{
    /**
     * All registered routes.
     *
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    /**
     * Allowed routes so they don't throw an error
     *
     * @var array
     */
    public $allowed = [
        'GET' => [
            'favicon.ico'
        ]
    ];

    /**
     * Load a user's routes file.
     *
     * @param string $path
     * @return Router
     */
    public static function load($path)
    {
        // Create new static instance
        $router = new static;

        // Load all routes
        $files = array_values(array_diff(scandir($path), ['.', '..']));
        foreach ($files as $file) {
            require ROOT . "/routes/{$file}";
        }

        // Return router
        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Register a PUT route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function put($uri, $controller)
    {
        $this->routes['PUT'][$uri] = $controller;
    }

    /**
     * Register a DELETE route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function delete($uri, $controller)
    {
        $this->routes['DELETE'][$uri] = $controller;
    }

    /**
     * Register a API route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function api($uri, $controller)
    {
        $this->routes['GET']['api/' . $uri] = $controller;
    }

    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     * @return mixed
     */
    public function direct($uri, $requestType)
    {
        // Listen for method
        if (isset($_POST['_method'])) {
            try {
                // Check if method is valid
                if (in_array($_POST['_method'], array_keys($this->routes))) {
                    $requestType = $_POST['_method'];
                } else {
                    writeLog("Tried to access unknown request method {$_POST['_method']}", 'WARN');
                    throw new HttpException("Request method <b>{$_POST['_method']}</b> is not allowed.");
                }
            } catch (HttpException $exception) {
                die($exception->text());
            }
        }

        try {
            // Check if uri correspond to request method
            if (array_key_exists($uri, $this->routes[$requestType])) {
                // Check if user defined a controller or callable function
                if (is_callable($this->routes[$requestType][$uri])) {
                    return call_user_func($this->routes[$requestType][$uri]);
                } else {
                    return $this->callAction(
                        ...explode('@', $this->routes[$requestType][$uri])
                    );
                }
            }

            // Check if this is an allowed route so it does not throw an error into log.
            if (array_key_exists($requestType, $this->allowed)) {
                if (!in_array($uri, $this->allowed[$requestType])) {
                    writeLog("Tried to access at /{$uri} with {$requestType} request method.", 'WARN');
                }
            }
            throw new HttpException(
                "Route <b>/{$uri}</b> does not have attached <b>{$requestType}</b> request method.",
                404
            );
        } catch (HttpException $exception) {
            die($exception->notFound());
        }
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $method
     * @return mixed
     */
    protected function callAction($controller, $method)
    {
        try {
            $controllerName = $controller;
            $controller = "App\\Controllers\\{$controller}";
            $controller = new $controller;

            // Check if method exists inside controller
            if (!method_exists($controller, $method)) {
                writeLog("Tried to access at /{$controllerName} does not respond to the {$method} method.", 'WARN');
                throw new HttpException(
                    "<b>{$controllerName}</b> does not respond to the <b>{$method}</b> request method."
                );
            }

            // Return controller with corresponding method
            return $controller->$method();

        } catch (HttpException $exception) {
            die($exception->text());
        }
    }
}