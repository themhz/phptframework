<?php

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        // Remove token cookie
        setcookie('token', '', time() - 3600, '/');
        unset($_COOKIE['token']);

        // Remove session
        unset($_SESSION['user']);
        session_destroy();

        header('Location: /');
    }
}
