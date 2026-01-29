<?php
namespace App\Components;

class Website {
  public function start() {
    // very minimal boot
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    require __DIR__ . '/../endpoints/public/template/index.php';
  }
}
