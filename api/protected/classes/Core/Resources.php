<?php

class Resources implements Interface_ICoreComponent {

  protected $resources;

  public function init() {
    $this->resources = require Api::app()->getVersionDir(Api::app()->request->getApiVersion()) . '/Resources/VersionResources.php';
  }

  public function get($controller, $action) {
    $controller = strtolower($controller);
    $action = strtolower($action);
    if ($controller === 'api') {
      return $this->resources;
    }
    if ($action === 'allactions') {
      return array($controller => $this->resources['resources'][$controller]);
    }
    return array($controller => array('action' => array($action => $this->resources['resources'][$controller]['actions'][$action])));
  }

}