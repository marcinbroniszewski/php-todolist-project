<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Validation, Session};
use App\Models\AuthModel;

class AuthController
{
   protected $model;

   public function __construct()
   {
      $this->model = new AuthModel();
   }

   public function register(): void
   {
      $errors = [];
      $oldValues = [];

      if (Session::check('signup-errors')) {
         $errors = Session::get('signup-errors');
      }

      if (Session::check('signup-values')) {
         $oldValues = Session::get('signup-values');
      }
      loadView("register", ['title' => 'Zarejestruj się', 'css' => 'sign-form', 'errors' => $errors, 'oldValues' => $oldValues]);
      Session::clearAll();
   }

   public function registerInfo(): void
   {
      if (!Session::check('signup_success')) {
         redirect('/');
      }

      loadView('register-info', ['title' => 'Rejestracja pomyślna', 'css' => 'sign-form']);
   }

   public function login(): void
   {
      $errors = [];
      $oldValues = [];

      if (Session::check('signin-errors')) {
         $errors = Session::get('signin-errors');
      }

      if (Session::check('signin-values')) {
         $oldValues = Session::get('signin-values');
      }
      loadView("login", ['title' => 'Zaloguj się', 'css' => 'sign-form', 'errors' => $errors, 'oldValues' => $oldValues]);
      Session::clearAll();
   }

   public function recoverPassword(): void
   {
      $errors = [];
      $oldValues = [];

      if (Session::check('recover-errors')) {
         $errors = Session::get('recover-errors');
      }

      if (Session::check('recover-values')) {
         $oldValues = Session::get('recover-values');
      }

      loadView('recover-password', ['title' => 'Odzyskiwanie hasła', 'css' => 'sign-form', 'errors' => $errors, 'oldValues' => $oldValues]);
      Session::clearAll();
   }

   public function recoverPasswordInfo(): void
   {
      if (!Session::check('recover_success')) {
         redirect('/');
      }

      loadView('recover-password-info', ['title' => 'Odzyskiwanie hasła pomyślne', 'css' => 'sign-form']);
   }

   public function resetPassword(): void
   {
      $token = $_GET['token'];

      if (!$token) {
         redirect('/');
      }

      $tokenErrors = [];
      $tokenData = $this->model->getTokenData($token, 'recover_pwd_tokens');

      if (empty($tokenData)) {
         $tokenErrors['token-not-exist'] = 'Podany token nie istnieje';
         loadView('reset-password', ['title' => 'Aktywacja konta', 'css' => 'sign-form', 'token' => $token, 'tokenErrors' => $tokenErrors]);
         exit;
      }

      $tokenTimestamp = strtotime($tokenData['token_expiry']);
      $currentTimestamp = time();

      if ($tokenTimestamp < $currentTimestamp) {
         $tokenErrors['token-expired'] = 'Token wygasł';
         $this->model->deleteUserToken($token, 'recover_pwd_tokens');
      }

      $formErrors = [];

      if (Session::check('reset-pwd-errors')) {
         $formErrors = Session::get('reset-pwd-errors');
      }

      loadView('reset-password', ['title' => 'Aktywacja konta', 'css' => 'sign-form', 'token' => $token, 'tokenErrors' => $tokenErrors, 'formErrors' => $formErrors]);
      Session::clearAll();
   }

   public function resetPasswordInfo(): void
   {
      if (!Session::check('reset-pwd-success')) {
         redirect('/');
      }

      loadView('reset-password-info', ['title' => 'Hasło zostało zmienione', 'css' => 'sign-form']);
   }

   //Sends new user data
   public function store(): void
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
         $user = $this->model->getUser($email);

         if ($user) {
            $errors['email'] = 'Konto o podanym e-mailu już istnieje';
            $oldValues['email'] = $email;
         }
      }

      //Checking if token was already created for that specific email
      if (empty($errors['email'])) {
         $emailFromUserTokens = $this->model->getEmailFromTokenTable($email, 'user_tokens');

         if ($emailFromUserTokens) {
            $errors['email'] = 'Konto o podanym e-mailu czeka na aktywację';
            $oldValues['email'] = $email;
         }
      }

      //Handling errors   
      if (!empty($errors)) {
         Session::set('signup-errors', $errors);

         if (isset($oldValues)) {
            Session::set('signup-values', $oldValues);
         }

         redirect('/rejestracja');
         exit();
      }

      $token = bin2hex(random_bytes(16));
      $tokenHash = hash("sha256", $token);
      $tokenExpiry = date("Y-m-d H:i:s", time() + 60 * 30);

      $userData = [
         'firstname' => $firstname,
         'lastname' => $lastname,
         'email' => $email,
         'pwd' => $pwd,
         'token' => $tokenHash,
         'token_expiry' => $tokenExpiry
      ];

      $activationLink = "http://localhost:3000/aktywacja-konta?token=" . $tokenHash;

      //Sending activation link
      $this->sendActivationEmail($email, $activationLink, $userData);
   }

   private function sendActivationEmail(string $email, string $activationLink, array $userData): void
   {
      $mail = require basePath('config/mail.php');

      $mail->addAddress($email);
      $mail->Subject = "Aktywacja konta";
      $mail->Body = <<<END
          Kliknij <a href="$activationLink">tutaj</a>, aby aktywować konto.
          END;

      if ($mail->send()) {
         $this->model->setUserToken(
            $userData['firstname'],
            $userData['lastname'],
            $userData['email'],
            $userData['pwd'],
            $userData['token'],
            $userData['token_expiry'],
         );

         Session::start();
         Session::set('signup_success', $userData['email']);

         redirect('/rejestracja-info');
      }
   }

   //Account activation
   public function activate(): void
   {
      $token = $_GET['token'];

      if (!$token) {
         redirect('/');
      }

      $errors = [];

      $userData = $this->model->getTokenData($token, 'user_tokens');

      if (!$userData) {
         $errors['token-not-exist'] = 'Podany token nie istnieje';
         loadView('account-activation', ['title' => 'Aktywacja konta', 'css' => 'sign-form', 'errors' => $errors]);
         exit;
      }

      $tokenTimestamp = strtotime($userData['token_expiry']);
      $currentTimestamp = time();

      if ($tokenTimestamp < $currentTimestamp) {
         $errors['token-expired'] = 'Token wygasł';
      }

      if (empty($errors)) {
         $firstname = $userData['firstname'];
         $lastname = $userData['lastname'];
         $email = $userData['email'];
         $pwd = $userData['pwd'];

         $this->model->setUser($firstname, $lastname, $email, $pwd);
      }

      $this->model->deleteUserToken($token, 'user_tokens');
      loadView('account-activation', ['title' => 'Aktywacja konta', 'css' => 'sign-form', 'errors' => $errors]);
   }

   public function authenticate(): never
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

         //Getting user data
         $user = $this->model->getUser($email);

         if (!$user) {
            $errors['email'] = 'Użytkownik o podanym e-mailu nie istnieje';
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
      redirect('/logowanie');
      exit;
   }

   public function sendRecoverToken(): void
   {
      if ($_SERVER['REQUEST_METHOD'] = 'POST') {
         $allowedFields = ['email'];
         $newRecoverData = array_intersect_key($_POST, array_flip($allowedFields));

         $email = $newRecoverData['email'];

         //Checking for errors
         $errors = [];
         $oldValues = [];

         if ($email === '') {
            $errors['email'] = 'Podaj e-mail';
         } else if (!Validation::email($email)) {
            $errors['email'] = 'Podany e-mail jest nieprawidłowy';
            $oldValues['email'] = $email;
         }
         
         //Checking if token was already created for that specific email
         if (empty($errors['email'])) {
            $emailFromRecoverPwdTokens = $this->model->getEmailFromTokenTable($email, 'recover_pwd_tokens');

            if ($emailFromRecoverPwdTokens) {
               $errors['email'] = 'Na podany adres e-mail został już wysłany link do resetu hasła';
               $oldValues['email'] = $email;
            }
         }

         //Checking if email exists in database
         if (empty($errors['email'])) {
            $user = $this->model->getUser($email);

            if ($user) {
               $token = bin2hex(random_bytes(16));
               $tokenHash = hash("sha256", $token);
               $tokenExpiry = date("Y-m-d H:i:s", time() + 60 * 30);

               $tokenData = [
                  'token' => $tokenHash,
                  'token_expiry' => $tokenExpiry
               ];

               $activationLink = "http://localhost:3000/reset-hasla?token=" . $tokenHash;
               $this->sendRecoverTokenEmail($email, $tokenData, $activationLink);
            } else {
               $errors['email'] = 'Nie ma użytkownika o podanym adresie e-mail';
               $oldValues['email'] = $email;
            }
         }

         Session::set('recover-errors', $errors);

         if (isset($oldValues)) {
            Session::set('recover-values', $oldValues);
         }

         redirect('/odzyskiwanie-hasla');
         exit();
      }
   }

   private function sendRecoverTokenEmail($email, $tokenData, $activationLink): void
   {
      $mail = require basePath('config/mail.php');

      $mail->addAddress($email);
      $mail->Subject = "Odzyskiwanie hasła";
      $mail->Body = <<<END
          Kliknij <a href="$activationLink">tutaj</a>, aby zmienić hasło.
          END;

      if ($mail->send()) {
         $this->model->setRecoverToken(
            $email,
            $tokenData['token'],
            $tokenData['token_expiry']
         );

         Session::start();
         Session::set('recover_success', $email);

         redirect('/odzyskiwanie-hasla-info');
      }
   }

   public function editPassword(): void
   {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $allowedFields = ['token', 'new-password', 'new-password-confirm'];
         $newAuthData = array_intersect_key($_POST, array_flip($allowedFields));
         $newAuthData = array_map('sanitize', $newAuthData);

         $token = $newAuthData['token'];
         $newPassword = $newAuthData['new-password'];
         $newPasswordConfirm = $newAuthData['new-password-confirm'];

         //Checking for errors
         $formErrors = [];

         if (!$token) {
            $this->resetPassword();
         }

         if ($newPassword === '') {
            $formErrors['new-password'] = 'Podaj hasło';
         } else if (!Validation::string($newPassword, 4, 50)) {
            $formErrors['new-password'] = 'Hasło musi się składać od 4 do 50 znaków';
         }

         if (!Validation::match($newPassword, $newPasswordConfirm)) {
            $formErrors['new-password-confirm'] = 'Podane hasła nie są takie same';
         }

         if (empty($formErrors)) {
            $tokenData = $this->model->getTokenData($token, 'recover_pwd_tokens');

            if (empty($tokenData)) {
               $this->resetPassword();
               exit;
            }

            $tokenTimestamp = strtotime($tokenData['token_expiry']);
            $currentTimestamp = time();

            if ($tokenTimestamp < $currentTimestamp) {
               $this->resetPassword();
               exit;
            }

            $email = $tokenData['email'];

            $this->model->updatePassword($email, $newPassword);
            $this->model->deleteUserToken($token, 'recover_pwd_tokens');
            Session::start();
            Session::set('reset-pwd-success', $email);

            redirect('/reset-hasla-info');
         } else {
            Session::start();
            Session::set('reset-pwd-errors', $formErrors);

            redirect('/reset-hasla?token=' . $token);
            exit();
         }
      }
   }

   public function logout(): void
   {
      Session::clear('user');
      $response['success'] = true;
      header('Content-Type: application/json');
      echo json_encode($response);
   }
}
