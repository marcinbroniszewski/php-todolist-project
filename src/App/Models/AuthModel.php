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

    public function getUser(string $email): array | null
    {
        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        return $user;
    }

    public function setUser(string $firstname, string $lastname, string $email, string $pwd): void {
        $params = [
            'firstname' => ucfirst(strtolower($firstname)),
            'lastname' => ucfirst(strtolower($lastname)),
            'email' => $email,
            'pwd' => password_hash($pwd, PASSWORD_DEFAULT)
         ];
   
         $this->db->query('INSERT INTO users (firstname, lastname, email, pwd) VALUES (:firstname, :lastname, :email, :pwd)', $params);
    }
}
