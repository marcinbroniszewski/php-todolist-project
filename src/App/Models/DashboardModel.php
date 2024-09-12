<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;

class DashboardModel
{
    protected $db;

    public function __construct()
    {
        $config = require basePath("config/db.php");
        $this->db = new Database($config);
    }

    public function getTodos(int $userId, string $date): array | null
    {
        $params = [
            'user_id' => $userId,
            'date' => $date
        ];

        $todos = $this->db->query('SELECT * FROM todos WHERE user_id = :user_id AND date = :date', $params)->fetchAll();
        return $todos;
    }

    public function setTodo(string $title, string $description, string $date, int $userId): void
    {
        $params = [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'user_id' => $userId
        ];

        $this->db->query('INSERT INTO todos (
            title, description, date, user_id  
          ) VALUES (
              :title, :description, :date, :user_id
          );', $params);
    }

    public function updateTodo(int $id, string $title, string $description, int $userId): void
    {
        $params = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'user_id' => $userId
        ];

        $this->db->query('UPDATE todos SET title = :title, description = :description WHERE user_id = :user_id AND id = :id;', $params);
    }

    public function deleteTodo(int $id, int $userId): void
    {
        $params = [
            'id' => $id,
            'user_id' => $userId
        ];

        $this->db->query('DELETE FROM todos WHERE user_id = :user_id AND id = :id', $params);
    }

    public function checkboxStatus(int $id, int $userId): int
    {
        $params = [
            'id' => $id,
            'user_id' => $userId
        ];

        $status = $this->db->query('SELECT checked FROM todos WHERE id = :id AND user_id = :user_id', $params)->fetch();
        return $status['checked'];
    }

    public function updateTodoCheckbox(int $id, int $userId, int $value): void
    {
        $params = [
            'id' => $id,
            'user_id' => $userId,
            'value'=> $value
        ];

        $this->db->query('UPDATE todos SET checked = :value WHERE id = :id AND user_id = :user_id', $params);
    }

    public function updatePassword(int $id, string $newPassword): void {
        $params = [
            'id'=> $id,
            'pwd' => password_hash($newPassword, PASSWORD_DEFAULT)
        ];

        $this->db->query('UPDATE users SET pwd = :pwd WHERE id = :id', $params);
    }
}
