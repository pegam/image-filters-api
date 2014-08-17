<?php

class Api_ApiErrorCode {

  private static $errCodes;

  public static function getMessage($code) {
    if (!isset(Api_ApiErrorCode::$errCodes)
            && isset(Api::app()->apiErrCodesConfLoc)
            && is_readable(Api::app()->apiErrCodesConfLoc)) {
      Api_ApiErrorCode::$errCodes = require Api::app()->apiErrCodesConfLoc;
    }
    $msgArr = Api_ApiErrorCode::$errCodes[$code];
    if ($msgArr && !isset($msgArr['errorCode'])) {
      $msgArr['errorCode'] = $code;
    }
    if (!Api::app()->debug) {
      unset($msgArr['moreInfo'], $msgArr['errorCode']);
    }
    return $msgArr;
  }

}