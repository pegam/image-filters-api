<?php

class Application implements Interface_IRunnable {

  public $environment = 'development';
  protected $components = array();
  protected $componentsConfig = array(
    'resources' => array(
      'class' => 'Resources',
    ),
  );
  protected $coreComponentsConfig = array(
      'errorHandler' => array(
        'class' => 'ErrorHandler',
      ),
      'shutdownHook' => array(
        'class' => 'ShutdownHook',
      ),
      'request' => array(
        'class' => 'ApiHttpRequest',
      ),
  );

  public function __construct($configLoc = null) {
    Api::setApplication($this);

    set_exception_handler(array($this, 'handleException'));

    $this->setEnv();

    $configObj = new Config($configLoc);
    $configArr = $configObj->parseConfig();
    $this->addConfig($configArr);

    $this->registerCoreComponents();

    register_shutdown_function(array($this, 'shutdown'), $this->debug);
  }

  public function __destruct() {
    if (isset($GLOBALS['image.filters.tmp.dirs'])) {
      foreach ($GLOBALS['image.filters.tmp.dirs'] as $dir) {
        if (file_exists($dir)) {
          Utils::delDirRecursive($dir);
        }
      }
    }
  }

  public function __get($name) {
    if ($this->hasComponent($name)) {
      return $this->getComponent($name);
    }
    throw new ApiException();
  }

  public function __isset($name) {
    return $this->hasComponent($name) && $this->getComponent($name) !== null;
  }

  public function handleException($exception) {
    restore_exception_handler();
    if (($handler = $this->getErrorHandler()) !== null) {
      $handler->handle($exception);
    } else {
      $this->end(500);
    }
  }

  public function getErrorHandler() {
    return $this->getComponent('errorHandler');
  }

  public function shutdown($debug) {
    if (($handler = $this->getShutdownHook()) !== null) {
      $handler->handle($debug);
    } else {
      $this->end(500);
    }
  }

  public function getShutdownHook() {
    return $this->getComponent('shutdownHook');
  }

  public function end($code = 0) {
    exit($code);
  }

  public function hasComponent($id) {
    return isset($this->components[$id]) || isset($this->componentsConfig[$id]);
  }

  public function getComponent($id) {
    if (isset($this->components[$id])) {
      return $this->components[$id];
    } else if (isset($this->componentsConfig[$id])) {
      $compConfig = $this->componentsConfig[$id];
      return $this->createComponent($id, $compConfig);
    }
  }

  public function setEnv() {
    $envFile = $_SERVER['DOCUMENT_ROOT'] . '/protected/environment';
    if (file_exists($envFile) && trim(file_get_contents($envFile)) === 'production') {
      $this->environment = 'production';
    } else {
      $this->environment = 'development';
    }
  }

  public function addConfig($config = null) {
    if (is_array($config)) {
      foreach ($config as $key => $value) {
        $this->$key = $value;
      }
    }
  }

  public function registerCoreComponents() {
    if ($this->coreComponentsConfig) {
      foreach ($this->coreComponentsConfig as $compId => $compConfig) {
        $this->createComponent($compId, $compConfig);
      }
    }
  }

  public function getTimezone() {
    return date_default_timezone_get();
  }

  public function setTimezone($tz) {
    date_default_timezone_set($tz);
  }

  public function run() {
    $this->addVersionConfig();
    $this->processRequest();
  }

  public function addVersionConfig() {
    $configLoc = BASE_PATH . '/protected/v' . $this->request->getApiVersion() . '/config/apiConfig.php';
    $configObj = new Config($configLoc);
    $configArr = $configObj->parseConfig();
    $this->addConfig($configArr);
  }

  public function processRequest() {
    $version = $this->request->getApiVersion();
    $controllerId = $this->request->getControllerId();
    $this->runController($version, $controllerId);
  }

  public function runController($version, $controllerId) {
    $controller = $this->createController($version, $controllerId);
    if ($controller === null) {
      throw new HttpException(400, 4);
    }
    $controller->init();
    $controller->auth();
    $controller->run();
  }

  public function createController($version, $controllerId) {
    $versionDir = $this->getVersionDir($version);
    $className = ucfirst($controllerId) . 'Controller';
    $classFile = $versionDir . '/controllers/' . $className . '.php';
    if (is_readable($classFile)) {
      if (!class_exists($className, false)) {
        require($classFile);
      }
      if (class_exists($className, false) && is_subclass_of($className, 'AController')) {
        return new $className($controllerId);
      }
    }
    return null;
  }

  public function getVersionDir($version) {
    $vDir = BASE_PATH . '/protected/v' . $version;
    if (!file_exists($vDir)) {
      throw new HttpException(400, 2);
    }
    return $vDir;
  }

  protected function createComponent($id, $compConfig) {
    $component = Api::createComponent($compConfig);
    $component->init();
    return $this->components[$id] = $component;
  }

}