<?php


namespace Flamingo\Exception;


use Exception;

class HttpException extends Exception
{
    /**
     * Not Found Exception
     *
     * @return mixed
     */
    public function notFound() {
        return require 'views/404.php';
    }

    /**
     * Exception for text based exceptions.
     *
     * @return mixed
     */
    public function text()
    {
        return require 'views/text.php';
    }

    /**
     * CSRF Protection Exception
     *
     * @return mixed
     */
    public function csrf()
    {
        return require 'views/csrf.php';
    }
}