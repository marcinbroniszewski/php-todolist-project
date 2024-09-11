<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;

class AuthModel
{
    protected $db;

    public function __construct()
    {
        $config = require basePath("config/db.php");
        $this->db = new Database($config);
    }

    public function getUser(string $email): array | bool
    {
        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        return $user;
    }

    public function setUserToken(string $firstname, string $lastname, string $email, string $pwd, string $token, string $tokenExipry): void
    {
        $params = [
            'firstname' => ucfirst(strtolower($firstname)),
            'lastname' => ucfirst(strtolower($lastname)),
            'email' => $email,
            'pwd' => password_hash($pwd, PASSWORD_DEFAULT),
            'token' => $token,
            'token_expiry' => $tokenExipry
        ];

        $this->db->query('INSERT INTO user_tokens (firstname, lastname, email, pwd, token, token_expiry) VALUES (:firstname, :lastname, :email, :pwd, :token, :token_expiry)', $params);
    }

    public function setUser(string $firstname, string $lastname, string $email, string $pwd): void
    {
        $params = [
            'firstname' => ucfirst(strtolower($firstname)),
            'lastname' => ucfirst(strtolower($lastname)),
            'email' => $email,
            'pwd' => $pwd,
        ];

        $this->db->query('INSERT INTO users (firstname, lastname, email, pwd) VALUES (:firstname, :lastname, :email, :pwd)', $params);
    }

    public function getTokenData(string $token, string $table): array | bool
    {
        $params = [
            'token' => $token
        ];

        $tokenData = $this->db->query("SELECT * FROM $table WHERE token = :token", $params)->fetch();
        return $tokenData;
    }

    public function deleteUserToken(string $token, string $table): void
    {
        $params = [
            'token' => $token
        ];

        $this->db->query("DELETE FROM $table WHERE token = :token", $params);
    }

    public function getEmailFromTokenTable(string $email, $table): array | bool
    {
        $params = [
            'email' => $email
        ];

        $email = $this->db->query("SELECT email FROM $table WHERE email = :email", $params)->fetch();
        return $email;
    }

    public function setRecoverToken(string $email, string $token, string $tokenExpiry): void
    {
        $params = [
            'email' => $email,
            'token' => $token,
            'token_expiry' => $tokenExpiry
        ];

        $this->db->query('INSERT INTO recover_pwd_tokens (email, token, token_expiry) VALUES (:email, :token, :token_expiry)', $params);
    }

    public function updatePassword(string $email, string $newPassword): void
    {
        $params = [
            'email'=> $email,
            'pwd' => password_hash($newPassword, PASSWORD_DEFAULT),
        ];

        $this->db->query('UPDATE users SET pwd = :pwd WHERE email = :email', $params);
    }
}
