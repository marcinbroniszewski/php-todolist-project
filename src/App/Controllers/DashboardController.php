<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Session;
use App\Models\DashboardModel;

class DashboardController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DashboardModel();
    }
    public function index()
    {
        if (!Session::check('user')) {
            redirect('/logowanie');
            exit;
        }

        $user = Session::get('user');

        if (!Session::check('date')) {
            Session::set("date", date("Y-m-d"));
        }

        $date = Session::get("date");

        $todos = $this->model->getTodos($user['id'], $date);
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
            exit;
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
        if (!Session::check('user')) {
            redirect('/logowanie');
            exit;
        }

        $title = $_POST['todo-title'];
        $description = $_POST['todo-description'];

        $user = Session::get('user');
        $userId = $user['id'];
        $date = Session::get('date');

        $this->model->setTodo($title, $description, $date, $userId);

        redirect('/panel');
    }

    public function editTodo()
    {
        if (!Session::check('user')) {
            redirect('/logowanie');
            exit;
        }

        $id = $_POST['id'];
        $id = intval($id);
        $title = $_POST['title'];
        $description = $_POST['description'];

        $user = Session::get('user');
        $userId = $user['id'];

        $this->model->updateTodo($id, $title, $description, $userId);
        redirect('/panel');
    }

    public function deleteTodo()
    {
        if (!Session::check('user')) {
            redirect('/logowanie');
            exit;
        }

        $id = $_POST['id'];
        $id = intval($id);

        $user = Session::get('user');
        $userId = $user['id'];

        $this->model->deleteTodo($id, $userId);
    }
    
    
    public function checkTodo()
    {
        if (!Session::check('user')) {
            redirect('/logowanie');
            exit;
        }

        $id = $_POST['id'];
        $id = intval($id);
        
        $user = Session::get('user');
        $userId = $user['id'];
        
        $checkboxStatus = $this->model->checkboxStatus($id, $userId);
        $newCheckboxStatus = ($checkboxStatus === 1) ? 0 : 1;

        $this->model->updateTodoCheckbox($id, $userId, $newCheckboxStatus);
    }

    public function logout()
    {
        Session::clear('user');
        $response['success'] = true;
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
