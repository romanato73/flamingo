<?php


namespace Flamingo\Console;

use Romanato\ColoringoCLI\Coloringo;

class Kernel
{
    private $argc;
    private $argv;
    private $console;
    private $availableCommands = [
        'route' => [
            'routes' => 'List all registered routes',
        ],
        'logs' => [
            'logs' => "\tShow all logs.",
            'log [date]' => 'Print out log with specific date.'
        ]
    ];

    /**
     * Starts the console.
     *
     * @param $argc
     * @param $argv
     */
    public function start($argc, $argv)
    {
        // Initialize Coloringo
        $this->console = new Coloringo();

        // Print kernel prefix
        print (
            $this->console->out('Flamingo Framework', 'light_magenta')
            .$this->console->newLine()
        );

        // Set arguments
        $this->argc = $argc;
        $this->argv = $argv;

        // Check for arguments
        if ($this->argc == 1) {
            $this->printUsage();
        } else {
            $this->listen();
        }
    }

    /**
     * Terminate the kernel.
     *
     * @param $startTime
     */
    public function terminate($startTime)
    {
        // Calculate the program runtime
        $endTime = (microtime(true) - $startTime);
        $runtime = substr($endTime, 0, 6);

        // Print execution time message
        print (
            $this->console->newLine()
            .$this->console->out("Program was executed in {$runtime}ms")
        );

        exit();
    }

    /**
     * Prints usage.
     */
    public function printUsage()
    {
        print($this->console->out('Available commands:', 'yellow'));

        foreach ($this->availableCommands as $category => $command) {
            print $this->console->out($category, 'yellow');
            foreach ($command as $syntax => $description) {
                print $this->console->inline("  $syntax", 'green');
                print $this->console->out("\t\t$description", 'light_grey');
            }
        }
    }

    /**
     * Listening for arguments.
     */
    private function listen()
    {
        $command = new Command();
        $command->runCommand($this->argc, $this->argv);
    }
}