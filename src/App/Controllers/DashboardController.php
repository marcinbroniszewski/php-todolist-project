<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Session, Database};

class DashboardController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath("config/db.php");
        $this->db = new Database($config);
    }

    public function index()
    {
        if (!Session::check('user')) {
            redirect('/logowanie');
        }

        $user = Session::get('user');

        if (!Session::check('date')) {
            Session::set("date", date("Y-m-d"));
        }

        $date = Session::get("date");

        $params = [
            'user_id' => $user['id'],
            'date' => $date
        ];

        $todos = $this->db->query('SELECT * FROM todos WHERE user_id = :user_id AND date = :date', $params)->fetchAll();
        $todos ?? $todos = array_reverse($todos);

        loadView("dashboard", ['title' => 'PHPTodoList panel', 'css' => 'dashboard', 'user' => $user, 'todos' => $todos]);
    }

    public function getDate()
    {
        if (Session::check('date')) {
            $date = Session::get('date');
        } else {
            Session::set("date", date("Y-m-d"));
            $date = Session::get('date');
        }

        header('Content-Type: application/json');
        echo json_encode(['date' => $date]);
    }

    public function sendDate()
    {
        $date = $_POST['date'];
        if ($date) {
            Session::set("date", $date);
        } else {
            Session::set("date", date("Y-m-d"));
        }
    }

    public function getAvatar()
    {
        if (!Session::check("user")) {
            redirect('/logowanie');
        }

        $user = Session::get('user');

        $extensions = ['png', 'jpg', 'jpeg', 'webp'];
        $avatarPath = null;

        foreach ($extensions as $extension) {
            $path = basePath('private/icons/' . $user['id'] . '.' . $extension);
            if (file_exists($path)) {
                $avatarPath = $path;
            }
        };

        if (!file_exists($avatarPath)) {
            $avatarPath = basePath('private/icons/default-icon.png');
        }

        $extension = pathinfo($avatarPath, PATHINFO_EXTENSION);

        header('Content-Type: image/' . $extension);
        readfile($avatarPath);
        exit;
    }

    public function addTodo()
    {
        $title = $_POST['todo-title'];
        $description = $_POST['todo-description'];

        if (!Session::check('user')) {
            redirect('/logowanie');
        }

        $user = Session::get('user');
        $userId = $user['id'];
        $date = Session::get('date');

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

        redirect('/panel');
    }
}
