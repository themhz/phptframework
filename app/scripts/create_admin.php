<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Components\RequestHandler;
use App\Models\Users;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$email = trim((string) RequestHandler::get('email'));
$password = (string) RequestHandler::get('password');

if ($email === '' || $password === '') {
    fwrite(STDERR, "Usage: php scripts/create_admin.php email=you@example.com password=yourpassword\n");
    exit(1);
}

$users = new Users();
$users->email = $email;

if ($users->CheckIfInsertedMailExists()) {
    fwrite(STDERR, "User already exists: $email\n");
    exit(1);
}

$users->password = password_hash($password, PASSWORD_DEFAULT);
$users->token = null;
$users->role = 'admin';
$users->insert();

fwrite(STDOUT, "Admin user created: $email\n");
