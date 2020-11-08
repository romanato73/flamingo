<?php


namespace Flamingo\Console;


use Flamingo\Console\Commands\LogsHandler;
use Flamingo\Console\Commands\RoutesHandler;
use Romanato\ColoringoCLI\Coloringo;

class Command
{
    private $console;

    /**
     * Set commands. [$command][$argc]
     *
     * @var int[]
     */
    private $commands = [
        'routes' => 1,
        'logs' => 1,
        'log' => 2
    ];

    /**
     * Commands constructor.
     */
    public function __construct()
    {
        $this->console = new Coloringo();
    }

    /**
     * Find command and run.
     *
     * @param int $argc
     * @param array $argv
     * @return int
     */
    public function runCommand(int $argc, array $argv)
    {
        // Get real arguments (subtract the program path)
        $argc -= 1;
        // Find argument
        foreach ($this->commands as $command => $parameters) {
            // Find command
            if ($parameters == $argc && $command == $argv[1]) {
                if ($argc > 1) {
                    unset($argv[0]);
                    unset($argv[1]);
                    $argv = array_values($argv);
                    return $this->$command($argv);
                }
                return $this->$command();
            }

            // Command found but invalid parameters
            if ($command == $argv[1] && $parameters != $argc) {
                return print $this->console->out(
                    "Command '$argv[1]' expected $parameters parameters ($argc obtained).",
                    'red'
                );
            }
        }

        return print $this->console->out("Command '$argv[1]' not found.", 'red');
    }

    /**
     * Prints all registered routes.
     */
    public function routes()
    {
        $routes = new RoutesHandler;

        $routes->load();
    }

    /**
     * Shows all logs.
     */
    public function logs()
    {
        $routes = new LogsHandler;

        $routes->load();
    }

    /**
     * Shows one specific log.
     *
     * @param array $argv
     */
    public function log($argv)
    {
        $routes = new LogsHandler;

        $routes->loadOne($argv);
    }
}