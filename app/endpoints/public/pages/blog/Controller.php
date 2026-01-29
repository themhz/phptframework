<?php
class Controller {
  public function get($id=null,$method='get',$templatePath=null){
    $content = __DIR__ . '/../../../endpoints/public/pages/blog/blog.php';
    include $templatePath;
  }
}
