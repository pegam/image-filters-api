<?php

class Config {

  protected $config_loc;
  protected $config_arr_raw;
  protected $config_arr;

  public function __construct($conf_file) {
    $this->config_loc = $conf_file;
    if (is_readable($this->config_loc)) {
      $this->config_arr_raw = require($this->config_loc);
    }
  }

  public function parseConfig() {
    if (is_array($this->config_arr_raw)) {
      foreach ($this->config_arr_raw as $key => $val) {
        $key = $this->replaceVariable($key);
        if ($key) {
          $this->config_arr[$key] = $val;
        }
      }
    }
    return $this->config_arr;
  }

  public function getConfig() {
    return $this->config_arr;
  }

  protected function replaceVariable($key) {
    $var = $this->hasVariable($key);
    if ($var) {
      $var_name = $var[1];
      if (isset(Api::app()->$var_name) && Api::app()->$var_name === $var[2]) {
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