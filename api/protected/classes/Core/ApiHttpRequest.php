<?php

class ApiHttpRequest implements Interface_ICoreComponent {

  const VERSION_PATTERN = '/^v[\d]+\.\d+$/';

  protected $method;
  protected $pathInfo;
  protected $version;
  protected $controllerId;
  protected $actionId;

  public function init() {
    # method
    if (isset($_SERVER['REQUEST_METHOD'])) {
      $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    } else {
      $this->method = 'GET';
    }
    if (!in_array($this->method, Api::app()->allowedHttpRequestMethods)) {
      throw new HttpException(400, 7);
    }
    # path info
    $pathInfo = '';
    if (isset($_SERVER['PATH_INFO'])) {
      $pathInfo = $_SERVER['PATH_INFO'];
    } else if (isset($_SERVER['REQUEST_URI'])) {
      $requestUri = $_SERVER['REQUEST_URI'];
      if (($pos = strpos($requestUri, '?')) !== false) {
        $requestUri = substr($requestUri, 0, $pos);
      }
      $pathInfo = urldecode($requestUri);
    } else {
      throw new ApiException();
    }
    $this->pathInfo = trim($pathInfo, '/');
    if (strlen(trim($this->pathInfo)) == 0) {
      $redirectUrl = 'redirectUrl_' . Api::app()->environment;
      Api::redirect(Api::app()->$redirectUrl);
    }
    # version
    $parts = explode('/', $this->pathInfo);
    if (!isset($parts[0]) || preg_match('/index\\.(php)|(html?)/i', $parts[0])) {
      $redirectUrl = 'redirectUrl_' . Api::app()->environment;
      Api::redirect(Api::app()->$redirectUrl);
    }
    $this->version = strtolower(trim($parts[0]));
    if (!preg_match(ApiHttpRequest::VERSION_PATTERN, $this->version)) {
      throw new HttpException(400, 2);
    }
    # controller
    if (!isset($parts[1])) {
      throw new HttpException(400, 3);
    }
    $this->controllerId = strtolower(trim($parts[1]));
    if (!isset($parts[2])) {
      throw new HttpException(400, 5);
    }
    # action
    $this->actionId = strtolower(trim($parts[2]));
    if (count($parts) > 3) {
      for ($i = 3; $i < count($parts); $i += 2) {
        $key = trim($this->stripSlashes($parts[$i]));
        $val = '';
        if (isset($parts[$i + 1])) {
          $val = trim($this->stripSlashes($parts[$i + 1]));
        }
        if (!isset($_GET[$key])) {
          $_GET[$key] = $val;
        }
      }
    }
    # normalize
    $this->normalizeRequest();
  }

  protected function normalizeRequest() {
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
      if (isset($_GET)) {
        $_GET = $this->stripSlashes($_GET);
      }
      if (isset($_POST)) {
        $_POST = $this->stripSlashes($_POST);
      }
      if (isset($_REQUEST)) {
        $_REQUEST = $this->stripSlashes($_REQUEST);
      }
      if (isset($_COOKIE)) {
        $_COOKIE = $this->stripSlashes($_COOKIE);
      }
    }
  }

  public function stripSlashes($data) {
    if (is_array($data)) {
      return array_map(array($this, 'stripSlashes'), $data);
    }
    return stripslashes($data);
  }

  public function getHttpMethod() {
    return $this->method;
  }

  public function getApiVersion() {
    return $this->version;
  }

  public function getControllerId() {
    return $this->controllerId;
  }

  public function getActionId() {
    return $this->actionId;
  }

}