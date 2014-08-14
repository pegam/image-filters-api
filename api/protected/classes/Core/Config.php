<?php

class Config {

  protected $configLoc;
  protected $configArrRaw;
  protected $configArr;

  public function __construct($confFile) {
    $this->configLoc = $confFile;
    if (is_readable($this->configLoc)) {
      $this->configArrRaw = require($this->configLoc);
    }
  }

  public function parseConfig() {
    if (is_array($this->configArrRaw)) {
      foreach ($this->configArrRaw as $key => $val) {
        $key = $this->replaceVariable($key);
        if ($key) {
          $this->configArr[$key] = $val;
        }
      }
    }
    return $this->configArr;
  }

  public function getConfig() {
    return $this->configArr;
  }

  protected function replaceVariable($key) {
    $var = $this->hasVariable($key);
    if ($var) {
      $varName = $var[1];
      if (isset(Api::app()->$varName) && Api::app()->$varName === $var[2]) {
        return $var[0];
      }
      return null;
    }
    return $key;
  }

  protected function hasVariable($key) {
    $m = array();
    if (preg_match('/([a-zA-Z_]\\w*)\\{\\{(\\w+):(\\w+)\\}\\}/', $key, $m)) {
      return array_slice($m, 1);
    }
    return null;
  }

}