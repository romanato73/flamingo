<?php


namespace App\Controllers;


class AuthController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }
}