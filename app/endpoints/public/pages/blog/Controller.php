<?php
class Controller {
  public function get($id=null,$method='get',$templatePath=null){
    $content = dirname(__FILE__) . '/blog.php';
    include $templatePath;
  }
}
