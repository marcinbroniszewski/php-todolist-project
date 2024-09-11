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

    public function getUserRegisterData(string $token): array | bool
    {
        $params = [
            'token' => $token
        ];

        $userData = $this->db->query('SELECT * FROM user_tokens WHERE token = :token', $params)->fetch();
        return $userData;
    }

    public function deleteUserToken(string $token): void {
        $params = [
            'token' => $token
        ];

        $this->db->query('DELETE FROM user_tokens WHERE token = :token', $params);
    }
}
