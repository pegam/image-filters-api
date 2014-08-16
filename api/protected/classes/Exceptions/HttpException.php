<?php

class HttpException extends ApiException {

  protected $httpStatusCode;

  public function __construct($httpStatusCode, $exceptionCode = 0, $message = null, array $replace = array(), Exception $previous = null) {
    $this->httpStatusCode = $httpStatusCode;
    if ($message === null) {
      $message = Http_HttpCode::getMessage($httpStatusCode);
    }
    foreach ($replace as $srch => $rplc) {
      $message = str_replace($srch, $rplc, $message);
    }
    parent::__construct($message, $exceptionCode, $previous);
  }

  public function getHttpStatusCode() {
    return $this->httpStatusCode;
  }

}