<?php


namespace Flamingo\Http;


abstract class Routes
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
     * Passed parameters
     *
     * @var array
     */
    public $parameters = [];

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

    protected function registerGetMethod($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    protected function registerPostMethod($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    protected function registerPutMethod($uri, $controller)
    {
        $this->routes['PUT'][$uri] = $controller;
    }

    protected function registerDeleteMethod($uri, $controller)
    {
        $this->routes['DELETE'][$uri] = $controller;
    }

    protected function registerResource($uri, $controller)
    {
        $this->registerGetMethod($uri, $controller . '@index');
        $this->registerGetMethod($uri . '/create', $controller . '@create');
        $this->registerPostMethod($uri, $controller . '@store');
        $this->registerGetMethod($uri . '/{id}', $controller . '@show');
        $this->registerGetMethod($uri . '/{id}/edit', $controller . '@edit');
        $this->registerPutMethod($uri . '/{id}', $controller . '@update');
        $this->registerDeleteMethod($uri . '/{id}', $controller . '@destroy');
    }

    protected function registerAPI($uri, $controller)
    {
        $this->routes['GET']['api/' . $uri] = $controller;
    }
}