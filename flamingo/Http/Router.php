<?php


namespace Flamingo\Http;


use DirectoryIterator;
use Flamingo\Exception\HttpException;

class Router extends Routes
{
    /**
     * Load a user's routes file.
     *
     * @param string $path
     * @return Router
     */
    public static function load(string $path)
    {
        // Create new static instance
        $router = new static;

        // Load all routes
        foreach (new DirectoryIterator($path) as $item) {
            if (!$item->isDot() && $item->isFile()) {
                require_once $path . $item->getFilename();
            }
        }

        // Return router
        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string|object $controller
     */
    public function get(string $uri, $controller)
    {
        $this->registerGetMethod($uri, $controller);
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string|object $controller
     */
    public function post(string $uri, $controller)
    {
        $this->registerPostMethod($uri, $controller);
    }

    /**
     * Register a PUT route.
     *
     * @param string $uri
     * @param string|object $controller
     */
    public function put(string $uri, $controller)
    {
        $this->registerPutMethod($uri, $controller);
    }

    /**
     * Register a DELETE route.
     *
     * @param string $uri
     * @param string|object $controller
     */
    public function delete(string $uri, $controller)
    {
        $this->registerDeleteMethod($uri, $controller);
    }

    /**
     * Register a API route.
     *
     * @param string $uri
     * @param string|object $controller
     */
    public function api(string $uri, $controller)
    {
        $this->registerAPI($uri, $controller);
    }

    /**
     * Register a resource route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function resource(string $uri, string $controller)
    {
        $this->registerResource($uri, $controller);
    }

    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     * @return mixed
     */
    public function direct(string $uri, string $requestType)
    {
        // Handle the requested method
        $requestType = $this->handleMethod($requestType);

        // Set parameters
        $uri = $this->expandParameters($uri, $requestType);

        try {
            // Check if uri and method are registered.
            if (!$this->routeIsRegistered($uri, $requestType)) {
                writeLog("Tried to access at /{$uri} with {$requestType} request method.", 'WARN');
                throw new HttpException(
                    "Route <b>/{$uri}</b> does not have attached <b>{$requestType}</b> request method.",
                    404
                );
            }

            // Generate route
            return $this->generateRoute($uri, $requestType, $this->parameters);
        } catch (HttpException $exception) {
            die($exception->notFound());
        }
    }

    /**
     * This function expands the parameters from the URL
     * and return them as an array.
     *
     * @param $uri
     * @param $requestType
     * @return string
     */
    protected function expandParameters($uri, $requestType)
    {
        // Expand the URI parts
        $uriParts = explode('/', $uri);
        // Loop through parts
        foreach (array_keys($this->routes[$requestType]) as $route) {
            // Expand each route
            $expanded = explode('/', $route);
            // Find count match for requestedUri and route in register
            if (count($expanded) == count($uriParts)) {
                // Find the match with main route (the first parameter)
                if ($uriParts[0] === $expanded[0]) {
                    for ($i = 0; $i < count($expanded); $i++) {
                        // Find parameter inside registered route
                        if (preg_match('/{([A-Za-z]+)}/', $expanded[$i]) && is_numeric($uriParts[$i])) {
                            $key = trim($expanded[$i], '{}');
                            $value = $uriParts[$i];
                            // Set parameter
                            $this->parameters[$key] = $value;
                            $uriParts[$i] = str_replace($uriParts[$i], $expanded[$i], $uriParts[$i]);
                        }
                    }
                }
            }
        }

        // Return the pattern of URL in routes
        return $uri = implode('/', $uriParts);
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $method
     * @param array $params
     * @return mixed
     */
    protected function callAction(string $controller, string $method, $params = [])
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
            return $controller->$method(...array_values($params));
        } catch (HttpException $exception) {
            die($exception->text());
        }
    }

    /**
     * Method handler.
     *
     * @param $requestType
     * @return mixed
     */
    protected function handleMethod($requestType)
    {
        // Listen for method that been passed by input
        if (isset($_POST['_method'])) {
            try {
                // Check if method is valid
                if (!in_array($_POST['_method'], array_keys($this->routes))) {
                    writeLog("Tried to access unknown request method {$_POST['_method']}", 'WARN');
                    throw new HttpException("Request method <b>{$_POST['_method']}</b> is not allowed.");
                }
                // Return method passed by input
                return $_POST['_method'];
            } catch (HttpException $exception) {
                die($exception->text());
            }
        }
        // Return passed request.
        return $requestType;
    }

    /**
     * Checks whether route is registered or not.
     *
     * @param $uri
     * @param $requestType
     * @return bool
     */
    protected function routeIsRegistered($uri, $requestType)
    {
        $registered = false;
        $allowed    = false;

        // Check if URI exists inside co-responding request type.
        if (array_key_exists($uri, $this->routes[$requestType])) {
            $registered = true;
        }

        // Check if this request type is inside allowed URIs
        if (array_key_exists($requestType, $this->allowed)) {
            if (in_array($uri, $this->allowed[$requestType])) {
                $allowed = true;
            }
        }

        // If route is registered or allowed return true
        if ($registered || $allowed) {
            return true;
        }

        // Otherwise return false
        return false;
    }

    /**
     * Router generator.
     *
     * @param $uri
     * @param $requestType
     * @param $params
     * @return mixed
     */
    protected function generateRoute($uri, $requestType, $params)
    {
        // Call user function if route is registered as function
        if (is_callable($this->routes[$requestType][$uri])) {
            return call_user_func_array($this->routes[$requestType][$uri], $params);
        }

        // Load and call relevant controller corresponding with requestType
        $args = explode('@', $this->routes[$requestType][$uri]);
        return $this->callAction(
            $args[0],
            $args[1],
            $params
        );
    }
}