<?php

class HttpException extends ApiException {

  protected $httpStatusCode;

  public function __construct($httpStatusCode, $exceptionCode = 0, $message = null, array $replace = null) {
    $this->httpStatusCode = $httpStatusCode;
    if ($message === null) {
      $message = Http_HttpCode::getMessage($httpStatusCode);
    }
    if ($replace !== null) {
      foreach ($replace as $srch => $rplc) {
        $message = str_replace($srch, $rplc, $message);
      }
    }
    parent::__construct($message, $exceptionCode);
  }

  public function getHttpStatusCode() {
    return $this->httpStatusCode;
  }

}