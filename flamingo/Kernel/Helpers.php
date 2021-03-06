<?php


namespace Flamingo\Kernel;


class Helpers
{

    /**
     * Load Helpers.
     *
     * @param string $path
     */
    public static function load(string $path)
    {
        $files = array_values(array_diff(scandir($path), ['.', '..']));
        foreach ($files as $file) {
            require_once __DIR__ . "/../Helpers/{$file}";
        }
    }
}