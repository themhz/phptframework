<?php

use App\Components\Database;
use App\Components\RequestHandler;
use App\Components\UserAuth;
use App\Models\Users;

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        $error = null;
        $content = dirname(__FILE__) . '/register.php';
        include $templatePath;
    }

    public function post($id = null, $method = 'post', $templatePath = null)
    {
        $email = trim((string) RequestHandler::get('email'));
        $password = (string) RequestHandler::get('password');
        $password_confirm = (string) RequestHandler::get('password_confirm');

        $error = null;

        if ($password !== $password_confirm) {
            $error = 'Passwords do not match.';
        }

        if ($error === null) {
            $users = new Users();
            $exists = $users->select()->where('email', '=', $email)->execute();
            if (!empty($exists)) {
                $error = 'A user with that email already exists.';
            }
        }

        if ($error === null) {
            $users = new Users();
            $users->email = $email;
            $users->password = $password;
            $users->role = 'user';

            $auth = new UserAuth(Database::getInstance());
            $id = $auth->register($users);

            if ($id) {
                header('Location: /login');
                return;
            }

            $error = 'Registration failed. Try again.';
        }

        $content = dirname(__FILE__) . '/register.php';
        include $templatePath;
    }
}
