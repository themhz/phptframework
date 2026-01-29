<?php

use App\Components\Database;
use App\Components\RequestHandler;

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        $error = null;
        $content = dirname(__FILE__) . '/reset_request.php';
        include $templatePath;
    }

    public function post($id = null, $method = 'post', $templatePath = null)
    {
        $email = trim((string) RequestHandler::get('email'));
        $error = null;

        // create password_resets table if missing
        $pdo = Database::getInstance();
        $pdo->exec("CREATE TABLE IF NOT EXISTS password_resets (
            id INT NOT NULL AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            INDEX(email),
            INDEX(token)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // check user exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // don't reveal whether user exists
            $content = dirname(__FILE__) . '/reset_request_sent.php';
            include $templatePath;
            return;
        }

        $token = bin2hex(random_bytes(16));
        $expires = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

        $ins = $pdo->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires)');
        $ins->execute([':email' => $email, ':token' => $token, ':expires' => $expires]);

        // send email via Mailer
        try {
            $resetLink = 'https://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/reset?token=' . $token;
            $mailer = new \App\Components\Mailer();
            $subject = 'Reset your password';
            $body = "<p>To reset your password click the link below (expires in 1 hour):</p><p><a href=\"$resetLink\">$resetLink</a></p>";
            $sent = $mailer->send($email, $subject, $body);
            if (!$sent) {
                error_log('Failed to send reset email to ' . $email);
            }
        } catch (\Throwable $e) {
            error_log('Mailer exception: ' . $e->getMessage());
        }

        $content = dirname(__FILE__) . '/reset_request_sent.php';
        include $templatePath;
    }
}
