<?php

class Http_HttpCode {

  private static $httpCodes;

  public static function getMessage($code, $full = true) {
    if (!isset(Http_HttpCode::$httpCodes)) {
      Http_HttpCode::$httpCodes = require Api::app()->httpCodesConfLoc;
    }
    if ($full) {
      return "HTTP/1.1 " . $code . " " . Http_HttpCode::$httpCodes[$code];
    }
    return Http_HttpCode::$httpCodes[$code];
  }

}