<?php

class Api_ApiErrorCode {

  private static $errCodes;

  public static function getMessage($code) {
    if (!isset(Api_ApiErrorCode::$errCodes)) {
      Api_ApiErrorCode::$errCodes = require Api::app()->apiErrCodesConfLoc;
    }
    $msgArr = Api_ApiErrorCode::$errCodes[$code];
    if ($msgArr && !isset($msgArr['errorCode'])) {
      $msgArr['errorCode'] = $code;
    }
    return $msgArr;
  }

}