<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Session, Validation};
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
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (Session::check('date')) {
                $date = Session::get('date');
            } else {
                Session::set("date", date("Y-m-d"));
                $date = Session::get('date');
            }

            header('Content-Type: application/json');
            echo json_encode(['date' => $date]);
        } else {
            redirect('/panel');
        }
    }

    public function sendDate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'];
            if ($date) {
                Session::set("date", $date);
            } else {
                Session::set("date", date("Y-m-d"));
            }
        } else {
            redirect('/panel');
        }
    }

    public function getAvatar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!Session::check("user")) {
                redirect('/logowanie');
            }

            $user = Session::get('user');

            $extensions = ['png', 'jpg', 'jpeg', 'webp'];
            $avatarPath = null;

            foreach ($extensions as $extension) {
                $path = basePath('uploads/avatars/' . $user['id'] . '.' . $extension);
                if (file_exists($path)) {
                    $avatarPath = $path;
                }
            };

            if (!$avatarPath) {
                $avatarPath = basePath('uploads/avatars/default-icon.png');
            }

            $extension = pathinfo($avatarPath, PATHINFO_EXTENSION);

            header('Content-Type: image/' . $extension);
            readfile($avatarPath);
            exit;
        } else {
            redirect('/panel');
        }
    }


    public function sendAvatar(): void
    {
        if (isset($_FILES['image']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::check("user")) {
                redirect('/logowanie');
            }

            $imgName = $_FILES['image']['name'];
            $imgSize = $_FILES['image']['size'];
            $imgType = $_FILES['image']['type'];
            $tmpName = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            $fileExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

            $mime = mime_content_type($tmpName);
            $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            //Checking if the file is correct
            if (in_array($mime, $allowedMimeTypes) && $error === 0 && $imgSize <= 100 * 1024) {
                $user = Session::get('user');

                $newImgName = $user['id'] . '.' . $fileExt;
                $fileDest = basePath('uploads/avatars') . '/' . $newImgName;

                //Checking if a file with this name exists
                $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
                foreach ($allowedExtensions as $ext) {
                    $existingFile = basePath('uploads/avatars') . '/' . $user['id'] . '.' . $ext;

                    if (file_exists($existingFile)) {
                        unlink($existingFile);
                    }
                }

                move_uploaded_file($tmpName, $fileDest);
                redirect('/panel');
            } else {
                echo "
                <script>
                  alert('Przesłanie obrazka nie powiodło się');
                </script>
                ";
            }
        } else {
            redirect('/panel');
        }
    }

    public function addTodo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::check('user')) {
                redirect('/logowanie');
            }

            $title = $_POST['todo-title'];
            $description = $_POST['todo-description'];

            $user = Session::get('user');
            $userId = $user['id'];
            $date = Session::get('date');

            $this->model->setTodo($title, $description, $date, $userId);

            redirect('/panel');
        } else {
            redirect('/panel');
        }
    }

    public function editTodo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::check('user')) {
                redirect('/logowanie');
            }

            $id = $_POST['id'];
            $id = intval($id);
            $title = $_POST['title'];
            $description = $_POST['description'];

            $user = Session::get('user');
            $userId = $user['id'];

            $this->model->updateTodo($id, $title, $description, $userId);
            redirect('/panel');
        } else {
            redirect('/panel');
        }
    }

    public function removeTodo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::check('user')) {
                redirect('/logowanie');
            }

            $id = $_POST['id'];
            $id = intval($id);

            $user = Session::get('user');
            $userId = $user['id'];

            $this->model->deleteTodo($id, $userId);
        } else {
            redirect('/panel');
        }
    }


    public function checkTodo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::check('user')) {
                redirect('/logowanie');
            }

            $id = $_POST['id'];
            $id = intval($id);

            $user = Session::get('user');
            $userId = $user['id'];

            $checkboxStatus = $this->model->checkboxStatus($id, $userId);
            $newCheckboxStatus = ($checkboxStatus === 1) ? 0 : 1;

            $this->model->updateTodoCheckbox($id, $userId, $newCheckboxStatus);
        } else {
            redirect('/panel');
        }
    }

    public function changePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::check('user')) {
                redirect('/logowanie');
            }

            $user = Session::get('user');
            $userId = $user['id'];
            $userId = intval($userId);

            $allowedFields = ['current-password', 'new-password', 'confirm-password'];
            $newPwdData = array_intersect_key($_POST, array_flip($allowedFields));

            $currentPassword = $newPwdData['current-password'];
            $newPassword = $newPwdData['new-password'];
            $confirmPassword = $newPwdData['confirm-password'];

            //Checking for errors
            $errors = [];

            if ($currentPassword === '') {
                $errors['current-password'] = 'Podaj aktualne hasło';
            }

            if ($newPassword === '') {
                $errors['new-password'] = 'Podaj nowe hasło';
            }

            if (empty($errors)) {
                if (!Validation::match($newPassword, $confirmPassword)) {
                    $errors['confirm-password'] = 'Podane hasła nie są takie same';
                }

                if (!password_verify($currentPassword, $user['pwd'])) {
                    $errors['current-password'] = 'Podane hasło jest nieprawidłowe';
                }
            }

            if (empty($errors)) {
                $this->model->updatePassword($userId, $newPassword);
                Session::clearAll();
                Session::start();
                Session::set('reset-pwd-success', 'success');
                redirect('/reset-hasla-info');
            } else {
                redirect('/panel');
            }
        } else {
            redirect('/panel');
        }
    }
}
