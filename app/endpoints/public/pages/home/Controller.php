<?php

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        $content = dirname(__FILE__) . '/home.php';
        include $templatePath;
    }
}
