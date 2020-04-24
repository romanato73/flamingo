<?php

namespace Flamingo\Kernel;


use Flamingo\Exception\HttpException;

class App
{
    /**
     * All registered keys.
     *
     * @var array
     */
    protected static $registry = [];

    /**
     * Bind a new key/value into the container.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    /**
     * Bind a all config files into the container.
     *
     * @param string $path
     */
    public static function configs($path)
    {
        $files = array_values(array_diff(scandir($path), ['.', '..']));
        foreach ($files as $key) {
            $value = require $path . $key;
            $key = pathinfo($key, PATHINFO_FILENAME);
            static::$registry[$key] = $value;
        }
    }

    /**
     * Retrieve a value from the registry.
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        try {
            // Check if key is bound to the container
            if (!array_key_exists($key, static::$registry)) {
                writeLog("Tried to access unbound registry '{$key}'.", 'ERROR');
                throw new HttpException("No <b>{$key}</b> is bound in the container.");
            }

            // Return corresponding registry data
            return static::$registry[$key];

        } catch (HttpException $exception) {
            die($exception->text());
        }
    }
}