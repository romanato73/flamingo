<?php


namespace Flamingo\Console\Commands;


use Romanato\ColoringoCLI\Coloringo;

class Handler
{
    protected $console;

    /**
     * RoutesHandler constructor.
     */
    public function __construct()
    {
        $this->console = new Coloringo();
    }
}