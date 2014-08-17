<?php

class Api {

  private static $app;

  public static function createApplication($config = null) {
    return new Application($config);
  }

  public static function app() {
    return Api::$app;
  }

  public static function setApplication($app) {
    if (Api::$app === null || $app === null) {
      Api::$app = $app;
    } else {
      throw new ApiException("There can be only one instance of the application.");
    }
  }

  public static function createComponent($config) {
    if (isset($config['class'])) {
      return new $config['class'];
    } else {
      throw new Exception("Component configuration has to be array containing key 'class'.");
    }
  }

  public static function redirect($location) {
    if (!headers_sent()) {
      header(Http_HttpCode::getMessage(303));
      header("Location: " . $location);
      APi::app()->end(0);
    }
  }

  public static function autoload($className) {
    $className = str_replace("_", "/", $className);
    $basePath = dirname(__FILE__);
    $path = $basePath . '/Core/' . $className . '.php';
    if (file_exists($path)) {
      require_once $path;
    } else {
      $path = $basePath . '/Exceptions/' . $className . '.php';
      if (file_exists($path)) {
        require_once $path;
      } else {
        $path = $basePath . '/' . $className . '.php';
        if (file_exists($path)) {
          require_once $path;
        }
      }
    }
  }

}

spl_autoload_register(array('Api', 'autoload'));