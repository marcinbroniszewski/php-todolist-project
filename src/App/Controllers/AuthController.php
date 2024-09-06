<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Database, Validation, Session};

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
      $errors = [];
      $oldValues = [];

      if (Session::check('signup-errors')) {
         $errors = Session::get('signup-errors');
      }

      if (Session::check('signup-errors')) {
         $oldValues = Session::get('signup-values');
      }
      loadView("register", ['title' => 'Zarejestruj się', 'css' => 'sign-form', 'errors' => $errors, 'oldValues' => $oldValues]);
      Session::clearAll();
   }
   
   public function login()
   {
      $errors = [];
      $oldValues = [];

      if (Session::check('signin-errors')) {
         $errors = Session::get('signin-errors');
     }
     
     if (Session::check('signin-values')) {
         $oldValues = Session::get('signin-values');
     }
      loadView("login", ['title' => 'Zaloguj się', 'css' => 'sign-form', 'errors' => $errors, 'oldValues'=> $oldValues]);
      Session::clearAll();
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
         Session::set('signup-errors', $errors);

         if (isset($oldValues)) {
            Session::set('signup-values', $oldValues);
         }

         header("Location: /rejestracja");
         exit();
      }

      //Create user account
      $params = [
         'firstname' => ucfirst(strtolower($firstname)),
         'lastname' => ucfirst(strtolower($lastname)),
         'email' => $email,
         'pwd' => password_hash($pwd, PASSWORD_DEFAULT)
      ];

      $this->db->query('INSERT INTO users (firstname, lastname, email, pwd) VALUES (:firstname, :lastname, :email, :pwd)', $params);

      header('Location: /rejestracja');
   }

   public function authenticate()
   {
      $allowedFields = ['email', 'pwd'];
      $newAuthData = array_intersect_key($_POST, array_flip($allowedFields));

      $email = $newAuthData['email'];
      $pwd = $newAuthData['pwd'];

      //Checking for errors
      $errors = [];
      $oldValues = [];

      if ($email === '') {
         $errors['email'] = 'Podaj adres e-mail';
      } else {
         $oldValues['email'] = $email;
      }

      if ($pwd === '') {
         $errors['pwd'] = 'Podaj hasło';
      }

      if (empty($errors)) {
         $params = [
            'email' => $email
         ];

         $user = $this->db->query('SELECT * FROM users where email = :email', $params)->fetch();

         if (!$user) {
            $errors['email'] = 'Użytkownik o podanym e-mailu nieistnieje';
         } else if (!password_verify($pwd, $user['pwd'])) {
            $errors['pwd'] = 'Podane hasło jest nieprawidłowe';
         } else {
            header('Location: /panel');
            Session::set('user', $user);
            exit;
         }
      }
      Session::set('signin-errors', $errors);
      Session::set('signin-values', $oldValues);
      header('Location: /logowanie');
      exit;
   }
}
