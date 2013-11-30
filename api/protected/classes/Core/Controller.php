<?php

class Controller implements Interface_IController, Interface_ICoreComponent, Interface_IRunnable {

  public function init() {
    spl_autoload_register(array($this, 'autoload'), true, true);
  }

  public function auth() {
    $auth = new ApiKeyAuth($clientId, $signature);
  }

  public function run() {
    $action = 'action' . ucfirst(Api::app()->request->getActionId());
    if (!method_exists($this, $action)) {
      throw new HttpException(400, 6);
    }

    $this->checkParams();
    $this->checkHttpMethod();

    $this->$action();
  }

  public function checkParams() {

  }

  public function checkHttpMethod() {
    $allowedHttpMethods = $this->getAllowedHttpMethods($action);
    if ($allowedHttpMethods !== null && !in_array(Api::app()->request->getHttpMethod(), $allowedHttpMethods)) {
      throw new HttpException(400, 7);
    }
  }

  public function getAllowedHttpMethods($action) {
    $reflection = new ReflectionClass($this);
    foreach ($reflection->getMethods() as $method) {
      if ($method->isPublic() && $method->getName() == $action) {
        return $this->parseDocComment($method);
      }
    }
    return null;
  }

  private function parseDocComment($method) {
    $httpMethods = array();
    $comments = $method->getDocComment();
    foreach (explode("\n", $comments) as $comment) {
      if (strpos($comment, '@methods') !== false) {
        $m = array();
        if (preg_match('/\s*\*\s+@methods\s+(.*)/', $comment, $m)) {
          $methods = trim($m[1]);
          if ($methods) {
            $httpMethods = array_merge($httpMethods, array_map('trim', array_map('strtoupper', preg_split('/[\s,]+/', $methods, null, PREG_SPLIT_NO_EMPTY))));
          }
        }
      }
    }
    return array_unique($httpMethods);
  }

  public function autoload($className) {
    $className = str_replace("_", "/", $className);
    $basePath = BASE_PATH . '/protected/' . Api::app()->request->getApiVersion();
    $path = $basePath . '/classes/' . $className . '.php';
    if (file_exists($path)) {
      require_once $path;
    } else {
      $path = $basePath . '/models/' . $className . '.php';
      if (file_exists($path)) {
        require_once $path;
      }
    }
  }

}