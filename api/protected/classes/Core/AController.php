<?php

abstract class AController implements Interface_IController, Interface_ICoreComponent, Interface_IRunnable {

  protected $controller;

  public function __construct($controller) {
    $this->controller = $controller;
  }

  public function init() {
    spl_autoload_register(array($this, 'autoload'), true, true);
  }

  public function auth() {
    $pathQuery = Api::app()->request->getPathQuery();
    if (!empty($pathQuery['client'])) {
      $auth = new Auth_ApiKeyAuth($pathQuery['client']);
      $auth->check();
    }
  }

  public function run() {
    $actionId = Api::app()->request->getActionId();
    $action = 'action' . ucfirst($actionId);
    if ($action !== 'actionAllActions' && !method_exists($this, $action)) {
      throw new HttpException(400, 6);
    }

    if ($actionId === 'AllActions' || !$this->checkHttpMethod($action)) {
      if ($this->printResourcesDocumentation($actionId) === null) {
        throw new HttpException(400, 7);
      }
    } else {
      $this->$action();
    }
  }

  public function checkHttpMethod($action) {
    $allowedHttpMethods = $this->getAllowedHttpMethods($action);
    if ($allowedHttpMethods !== null && !in_array(Api::app()->request->getHttpMethod(), $allowedHttpMethods)) {
      return false;
    }
    return true;
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

  public function parseDocComment(ReflectionMethod $method) {
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

  protected function printResourcesDocumentation($actionId) {
    $res = Api::app()->resources->get($this->controller, $actionId);
    if ($res) {
      if (!headers_sent()) {
        header(Http_HttpCode::getMessage(200));
        header('Content-Type: application/json');
      }
      echo json_encode($res, JSON_PRETTY_PRINT);
    }
    return $res;
  }

}