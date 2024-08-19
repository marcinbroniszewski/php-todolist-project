<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Validation;

class AuthController
{
   public function register()
   {
      loadView("register", ['title' => 'Zarejestruj się', 'css' => 'sign-form']);
   }
   public function login()
   {
      loadView("login", ['title' => 'Zaloguj się', 'css' => 'sign-form']);
   }

   public function store()
   {
      $allowedFields = ['firstname', 'lastname', 'email', 'pwd', 'confirm-pwd'];

      $newAuthData = array_intersect_key($_POST, array_flip($allowedFields));

      $newAuthData = array_map('sanitize', $newAuthData);

      $firstname = $newAuthData['firstname'];
      $lastname = $newAuthData['lastname'];
      $email = $newAuthData['email'];
      $pwd = $newAuthData['pwd'];
      $confirmPwd = $newAuthData['confirm-pwd'];

      $errors = [];
      $oldValues = [];

      if ($firstname === '') {
         $errors['firstname'] = 'Podaj imię';
      } else if (!Validation::string($firstname, 3, 15)) {
         $errors['firstname'] = 'Podaj prawdziwe imię';
         $oldValues['firstname'] = $firstname;
      }

      if ($lastname === '') {
         $errors['lastname'] = 'Podaj nazwisko';
      } else if (!Validation::string($lastname, 3, 25)) {
         $errors['lastname'] = 'Podaj prawdziwe nazwisko';
         $oldValues['lastname'] = $lastname;
      }

      if ($email === '') {
         $errors['email'] = 'Podaj e-mail';
      } else if (!Validation::email($email)) {
         $errors['email'] = 'Podany e-mail jest nieprawidłowy';
         $oldValues['email'] = $email;
      }

      if ($pwd === '') {
         $errors['pwd'] = 'Podaj hasło';
      } else if (!Validation::string($pwd, 4, 50)) {
         $errors['pwd'] = 'Hasło musi się składać od 4 do 50 znaków';
      }

      if (!Validation::match($pwd, $confirmPwd)) {
         $errors['confirmPwd'] = 'Podane hasła nie są takie same';
      }

      if (isset($errors)) {
         session_start();
         $_SESSION['signup-errors'] = $errors;

         if (isset($oldValues)) {
            $_SESSION['signup-values'] = $oldValues;
         }

         header("Location: /rejestracja");
         exit();
      }
   }
}
