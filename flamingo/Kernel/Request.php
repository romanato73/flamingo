<?php


namespace Flamingo\Kernel;


class Request
{
    /**
     * Fetch the request URI.
     *
     * @return string
     */
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
    }

    /**
     * Fetch the request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function setParams($params)
    {
        $protected = ['_method', '_csrf'];

        foreach ($params as $key => $value) {
            if (!in_array($key, $protected)) {
                $this->{$key} = inputData($value);
            }
        }
    }
}