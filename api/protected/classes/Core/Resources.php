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
    if ($controller === 'api') {
      $return = $this->resources;
    }
    if ($action === 'allactions') {
      $return = array($controller => $this->resources['resources'][$controller]);
    }
    if (isset($this->resources['resources'][$controller]['actions'][$action])) {
      $return = array($controller => array('action' => array($action => $this->resources['resources'][$controller]['actions'][$action])));
    }
    if ($return) {
      $return = array('version' => Api::app()->request->getApiVersion()) + $return;
      return $return;
    }
    return null;
  }

}