<?php

class ApiController extends Controller {

  /**
   * @methods GET
   */
  public function actionAllActions () {
//    $reflection = new ReflectionClass($this);
//    foreach ($reflection->getMethods() as $method) {
//      if ($method->isPublic() && $method->getName() == $action) {
//        return $this->parseDocComment($method);
//      }
//    }
    $ret = array(
        'resource' => array(
            
        )
    );
    echo "YO!";
  }

}