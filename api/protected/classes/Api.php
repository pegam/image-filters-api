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
      throw new ApiException('Aplikacija moze biti kreirana samo jedanput.');
    }
  }

  public static function createComponent($config) {
    if (isset($config['class'])) {
      return new $config['class'];
    } else {
      throw new CException('Konfiguracija komponente mora biti niz koji ima element \'class\'.');
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
    $basePath = dirname(__FILE__);
    $path = $basePath . '/Core/' . $className . '.php';
    if (file_exists($path)) {
      require_once $path;
    } else {
      $path = $basePath . '/Exceptions/' . $className . '.php';
      if (file_exists($path)) {
        require_once $path;
      } else {
        $path = $basePath . '/' . str_replace("_", "/", $className) . '.php';
        if (file_exists($path)) {
          require_once $path;
        }
      }
    }
  }

}

spl_autoload_register(array('Api', 'autoload'));