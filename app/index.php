<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Components\Website;
 
$website = new Website();
$website->start();
