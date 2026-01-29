<?php

namespace App\Components;
use App\Models\Users;
use App\Models\Settings;
use App\Components\Mailer;

class UserAuth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($user) {
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        $result = $user->insert();

        if ($result) {
            // send welcome email if SMTP configured
            try {
                $mailer = new Mailer();
                $subject = 'Welcome to phptframework';
                $body = "<p>Hello,</p><p>Thank you for registering. You can login at <a href='http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "/login'>Login</a>.</p>";
                $mailer->send($user->email, $subject, $body);
            } catch (\Throwable $e) {
                error_log('Mailer error: ' . $e->getMessage());
            }
        }

        return $result;
    }

    public function login($email, $password) {

        $users = new Users();
        $user = $users->select()->where("email","=",$email)->execute();
        $user = empty($user)?false:$user[0];

        
        if ($user && password_verify($password, $user['password']   )) {        
            // password is correct
            // generate a new session token
            $token = bin2hex(openssl_random_pseudo_bytes(16));            
            $users->token = $token;
            $result = $users->update()->where("id","=",$user['id'])->execute();

            if($result){
                $_SESSION["user"] = $user;               
                // set the token cookie if remember me is checked for 1 hour                                                                
                //setcookie('token', $token, time() + 3600,'/'); // 1 hour expiration         
                setcookie('token', $token, time() + (365 * 24 * 60 * 60), '/'); // 1 year expiration
                return true;
            }
        }
        return false;
    }

    public function authenticateToken() {
        $token = isset($_COOKIE['token']) ? $_COOKIE['token'] : RequestHandler::get("token");
                
        if ($token) {
            $users = new Users();
            $users->token = $token;    
            $result = $users->select()->where("token", "=", $token)->execute();
            if(empty($result)){
                $settings = new Settings();
                $result = $settings->select()->where("crontoken", "=", $token)->execute();                                               
            }            
            
            return !empty($result) ? $result[0] : null;
        }
    
        return null;
    }
    
    
}

