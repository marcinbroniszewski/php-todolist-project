<?php

declare(strict_types=1);

namespace App\Controllers;

class AuthController {
    public function register() {
       loadView("register", ['title' => 'Zarejestruj się', 'css' => 'sign-form']);
    }
    public function login() {
       loadView("login", ['title' => 'Zaloguj się', 'css' => 'sign-form']);
    }
}