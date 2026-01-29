<?php
class Controller {
  public function show($slug=null,$method='get',$templatePath=null){
    $content = __DIR__ . '/../../post.php';
    include $templatePath;
  }
  public function comment($slug=null,$method='post',$templatePath=null){
    // stub for comment handling
  }
}
