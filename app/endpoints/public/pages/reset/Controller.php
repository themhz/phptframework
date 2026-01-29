<?php

use App\Components\Database;
use App\Components\RequestHandler;

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        $token = (string) RequestHandler::get('token');
        $error = null;

        if (empty($token)) {
            $error = 'Invalid reset token.';
            $content = dirname(__FILE__) . '/reset.php';
            include $templatePath;
            return;
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT email, expires_at FROM password_resets WHERE token = :token');
        $stmt->execute([':token' => $token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || strtotime($row['expires_at']) < time()) {
            $error = 'Reset token is invalid or expired.';
        }

        $content = dirname(__FILE__) . '/reset.php';
        include $templatePath;
    }

    public function post($id = null, $method = 'post', $templatePath = null)
    {
        $token = (string) RequestHandler::get('token');
        $password = (string) RequestHandler::get('password');
        $password_confirm = (string) RequestHandler::get('password_confirm');

        $error = null;

        if ($password !== $password_confirm) {
            $error = 'Passwords do not match.';
        }

        if ($error === null) {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare('SELECT email, expires_at FROM password_resets WHERE token = :token');
            $stmt->execute([':token' => $token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row || strtotime($row['expires_at']) < time()) {
                $error = 'Reset token is invalid or expired.';
            } else {
                // update user password
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $upd = $pdo->prepare('UPDATE users SET password = :pw WHERE email = :email');
                $upd->execute([':pw' => $newHash, ':email' => $row['email']]);

                // remove the reset record
                $del = $pdo->prepare('DELETE FROM password_resets WHERE token = :token');
                $del->execute([':token' => $token]);

                header('Location: /login');
                return;
            }
        }

        $content = dirname(__FILE__) . '/reset.php';
        include $templatePath;
    }
}
