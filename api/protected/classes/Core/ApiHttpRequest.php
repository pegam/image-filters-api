<?php

class ApiHttpRequest implements Interface_ICoreComponent {

  const VERSION_PATTERN = '/^v[\d]+\.\d+$/';

  protected $method;
  protected $fullPath;
  protected $pathWithQuery;
  protected $pathQuery;
  protected $signature;
  protected $path;
  protected $version;
  protected $controllerId;
  protected $actionId;

  public function init() {
    # SSL
    if (Api::app()->ssl) {
      if (!empty($_SERVER['HTTPS'])
              && strtolower($_SERVER['HTTPS']) !== 'off'
              || $_SERVER['SERVER_PORT'] == 443) {
          throw new HttpException(400, 26);
      }
    }
    # method
    if (isset($_SERVER['REQUEST_METHOD'])) {
      $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    } else {
      $this->method = 'GET';
    }
    if (!in_array($this->method, Api::app()->allowedHttpRequestMethods)) {
      if ($this->method === 'OPTIONS') {
        if (!headers_sent()) {
          header("HTTP/1.1 200 OK");
          APi::app()->end();
        }
      }
      throw new HttpException(400, 7);
    }
    # path info & query
    $fullPath = '';
    $pathQueryStr = '';
    $pathQuery = array();
    if (isset($_SERVER['REQUEST_URI'])) {
      $requestUri = $_SERVER['REQUEST_URI'];
      if (($pos = strpos($requestUri, '?')) !== false) {
        $pathQueryStr = substr($requestUri, $pos + 1);
        parse_str($pathQueryStr, $pathQuery);
        $requestUri = substr($requestUri, 0, $pos);
      }
      $fullPath = urldecode($requestUri);
    } else {
      throw new ApiException();
    }
    $this->fullPath = trim($fullPath, '/');
    $this->pathQuery = $pathQuery;
    $parts = explode('/', $this->fullPath);
    if (Api::app()->secureApi) {
      if (empty($this->pathQuery['client'])) {
        throw new HttpException(400, 28);
      }
      # signature
      if (empty($parts[0])) {
        throw new HttpException(401);
      }
      $this->signature = trim(array_shift($parts));
    }
    $this->path = implode('/', $parts);
    $this->pathWithQuery = $this->path . '?' . $pathQueryStr;
    # version
    if (empty($parts[0]) || preg_match('/index\\.(?:php)|(?:html?)/i', $parts[0])) {
      array_shift($parts);
    }
    if (!isset($parts[0]) || !preg_match('/v\\d+/i', $parts[0])) {
      $this->version = 'v' . Api::app()->latestActiveVersion;
    } else {
      $this->version = strtolower(trim(array_shift($parts)));
    }
    if (!preg_match(ApiHttpRequest::VERSION_PATTERN, $this->version)) {
      throw new HttpException(400, 2);
    }
    # controller
    if (!isset($parts[0])) {
      $this->controllerId = 'Api';
    } else {
      $this->controllerId = strtolower(trim(array_shift($parts)));
    }
    # action
    if (!isset($parts[0])) {
      $this->actionId = 'AllActions';
    } else {
      $this->actionId = strtolower(trim(array_shift($parts)));
    }
    if (count($parts) > 0) {
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

  public function getFullPath() {
    return $this->fullPath;
  }

  public function getPathQuery() {
    return $this->pathQuery;
  }

  public function getSignature() {
    return $this->signature;
  }

  public function getPath() {
    return $this->path;
  }

  public function getPathWithQuery() {
    return $this->pathWithQuery;
  }

}