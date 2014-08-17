<?php

class ShutdownHook implements Interface_ICoreComponent {

  public function init() {}

  public function handle($debug = false) {
    $error = error_get_last();
    if ($debug && $error !== null) {
      $msg = "Error: '{$error['message']}' in {$error['file']}:{$error['line']}";
      $e = new HttpException(500, 0, $msg);
      Api::app()->handleException($e);
    }
  }

}