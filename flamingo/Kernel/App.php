<?php

namespace Flamingo\Kernel;


use Flamingo\Exception\HttpException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Pagination\Paginator;

class App
{
    /**
     * All registered keys.
     *
     * @var array
     */
    protected static $registry = [];

    public static function init()
    {
        /**
         * Initialize database
         */
        (new self)->initializeDatabase();

        /**
         * Initialize pagination
         */
        (new self)->initializePagination();
    }

    /**
     * Bind a new key/value into the container.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function bind(string $key, $value)
    {
        static::$registry[$key] = $value;
    }

    /**
     * Bind a all config files into the container.
     *
     * @param string $path
     */
    public static function configs(string $path)
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
    public static function get(string $key)
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

    /**
     * Initialize Eloquent ORM
     *
     * Eloquent ORM provides a beautiful, simple
     * ActiveRecord implementation for working
     * with your database. Each database table has
     * a corresponding "Model" which is used to
     * interact with that table.
     * @see https://laravel.com/docs/master/eloquent
     */
    public function initializeDatabase()
    {
        $capsule = new Capsule();

        // Create connection
        $capsule->addConnection([
            'driver' => App::get('database')['driver'],
            'host' => App::get('database')['host'],
            'username' => App::get('database')['user'],
            'password' => App::get('database')['password'],
            'database' => App::get('database')['database'],
            'charset' => App::get('database')['charset'],
            'collation' => App::get('database')['collation'],
            'prefix' => App::get('database')['prefix']
        ]);

        // Boot eloquent
        $capsule->bootEloquent();
    }

    /**
     * Initialize data for pagination with
     * Illuminate/Pagination package.
     * @see https://laravel.com/docs/master/pagination
     */
    public function initializePagination()
    {
        Paginator::currentPageResolver(function ($pageName = 'page') {
            return (int) ($_GET[$pageName] ?? 1);
        });
    }
}