<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class AuthController
{
   protected $db;

   public function __construct()
   {
      $config = require basePath("config/db.php");
      $this->db = new Database($config);
   }

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

      //Checking for errors
      $errors = [];
      $oldValues = [];

      if ($firstname === '') {
         $errors['firstname'] = 'Podaj imię';
      } else if (!Validation::string($firstname, 3, 15) || preg_match('/[\d\W]/', $firstname)) {
         $errors['firstname'] = 'Podaj prawdziwe imię';
         $oldValues['firstname'] = $firstname;
      } else {
         $oldValues['firstname'] = $firstname;
      }

      if ($lastname === '') {
         $errors['lastname'] = 'Podaj nazwisko';
      } else if (!Validation::string($lastname, 3, 25)  || preg_match('/[\d\W]/', $lastname)) {
         $errors['lastname'] = 'Podaj prawdziwe nazwisko';
         $oldValues['lastname'] = $lastname;
      } else {
         $oldValues['lastname'] = $lastname;
      }

      if ($email === '') {
         $errors['email'] = 'Podaj e-mail';
      } else if (!Validation::email($email)) {
         $errors['email'] = 'Podany e-mail jest nieprawidłowy';
         $oldValues['email'] = $email;
      } else {
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

      //Checking if email exists in database
      if (empty($errors['email'])) {
         $params = [
            'email' => $email
         ];
         
         $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

         if ($user) {
            $errors['email'] = 'Konto o podanym e-mailu już istnieje';
            $oldValues['email'] = $email;
         }
      }

      //Handling errors   
      if (!empty($errors)) {
         session_start();
         $_SESSION['signup-errors'] = $errors;

         if (isset($oldValues)) {
            $_SESSION['signup-values'] = $oldValues;
         }

         header("Location: /rejestracja");
         exit();
      }

      //Create user account
      $params = [
         'firstname' => ucfirst(strtolower($firstname)),
         'lastname'=> ucfirst(strtolower($lastname)),
         'email'=> $email,
         'pwd'=> $pwd,
      ];

      $this->db->query('INSERT INTO users (firstname, lastname, email, pwd) VALUES (:firstname, :lastname, :email, :pwd)', $params);

      header('Location: /logowanie');
   }
}
