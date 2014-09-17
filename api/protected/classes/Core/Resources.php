<?php

class Resources implements Interface_ICoreComponent {

  protected $resources;

  public function init() {
    $this->resources = require Api::app()->getVersionDir(Api::app()->request->getApiVersion()) . '/Resources/VersionResources.php';
  }

  public function get($controller, $action) {
    $controller = strtolower($controller);
    $action = strtolower($action);
    $return = null;
    if ($controller === 'resources') {
      $return = $this->resources;
    } else if ($action === 'allactions') {
      if (isset($this->resources['resources'][$controller])) {
        $return = array($controller => $this->resources['resources'][$controller]);
      }
    } else if (isset($this->resources['resources'][$controller]['actions'][$action])) {
      $return = array($controller => array('action' => array($action => $this->resources['resources'][$controller]['actions'][$action])));
    }
    if ($return) {
      $return = array('version' => Api::app()->request->getApiVersion()) + $return;
      $this->setVersion($return);
      return $return;
    }
    return null;
  }

  public function setVersion(array &$resources) {
    foreach ($resources as $key => &$val) {
      if ($key === 'path') {
        $val = str_replace('{version}', 'v' . Api::app()->request->getApiVersion(), $val);
      } else if (is_array($val)) {
        $this->setVersion($val);
      }
    }
  }

}