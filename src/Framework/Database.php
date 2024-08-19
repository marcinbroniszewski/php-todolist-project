<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException;

class Database
{
    public $conn;

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new PDOException("Database connection failed: {$e->getMessage()}");
        }
    }

    public function query(string $query)
    {
        try {
            $stm = $this->conn->prepare($query);
            $stm->execute();
            return $stm;
        } catch (PDOException $e) {
            throw new PDOException("Query failed to execute: {$e->getMessage()}");
        }
    }
}
