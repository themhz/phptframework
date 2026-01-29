<?php

use App\Components\Database;
use App\Components\RequestHandler;
use App\Components\UserAuth;

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        $error = null;
        $next = (string) (RequestHandler::get('next') ?? '');
        $content = dirname(__FILE__) . '/login.php';
        include $templatePath;
    }

    public function post($id = null, $method = 'post', $templatePath = null)
    {
        $email = trim((string) RequestHandler::get('email'));
        $password = (string) RequestHandler::get('password');
        $next = (string) (RequestHandler::get('next') ?? '');

        $auth = new UserAuth(Database::getInstance());
        if ($auth->login($email, $password)) {
            if ($next !== '' && str_starts_with($next, '/')) {
                header('Location: ' . $next);
            } else {
                header('Location: /admin/posts');
            }
            return;
        }

        $error = 'Invalid email or password.';
        // keep next so the form can retry
        $content = dirname(__FILE__) . '/login.php';
        include $templatePath;
    }
}
