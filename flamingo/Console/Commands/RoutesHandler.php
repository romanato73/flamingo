<?php

namespace Flamingo\Console\Commands;

use Flamingo\Kernel\Router;

class RoutesHandler extends Handler
{
    /**
     * Load all routes.
     */
    public function load()
    {
        print $this->console->out('Registered routes:', 'yellow');
        // Import all routes
        $webRoutes = 'routes/web.php';
        $apiRoutes = 'routes/api.php';
        // Show web routes
        print $this->console->out('  Web routes:', 'yellow');
        $this->handler($webRoutes);
        // Show api routes
        print $this->console->out('  API routes:', 'yellow');
        $this->handler($apiRoutes);
    }

    /**
     * Routes handler.
     *
     * @param $routes
     */
    private function handler($routes)
    {
        // Generate new router
        $router = new Router();

        include $routes;

        // Loop through routes
        foreach ($router->routes as $method => $route) {
            foreach ($route as $uri => $controller) {
                if (is_string($controller)) {
                    print (
                        $this->console->inline("  /{$uri} ", 'green')
                        .$this->console->inline($controller, 'yellow')
                        .$this->console->newLine()
                    );
                }

                if (is_callable($controller)) {
                    print (
                        $this->console->inline("  /{$uri} ", 'green')
                        .$this->console->inline('Callable::self', 'magenta')
                        .$this->console->newLine()
                    );
                }
            }
        }
    }
}