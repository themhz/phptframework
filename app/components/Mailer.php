<?php
namespace App\Components;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        // Configure using env
        $host = $_ENV['SMTP_HOST'] ?? '';
        $port = (int)($_ENV['SMTP_PORT'] ?? 587);
        $user = $_ENV['SMTP_USER'] ?? '';
        $pass = $_ENV['SMTP_PASS'] ?? '';
        $secure = $_ENV['SMTP_SECURE'] ?? 'tls';
        $from = $_ENV['MAIL_FROM'] ?? $user;
        $fromName = $_ENV['MAIL_FROM_NAME'] ?? 'phptframework';

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $user;
        $this->mailer->Password = $pass;
        if (strtolower($secure) === 'ssl') {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $this->mailer->Port = $port;

        // From
        $this->mailer->setFrom($from, $fromName);
        $this->mailer->isHTML(true);
    }

    public function send(string $to, string $subject, string $body): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            return $this->mailer->send();
        } catch (\Throwable $e) {
            error_log('Mail send failed: ' . $e->getMessage());
            return false;
        }
    }
}
