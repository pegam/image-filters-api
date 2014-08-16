<?php

class ErrorHandler implements Interface_ICoreComponent {

  public function init() {}

  public function handle(Exception $exception) {
    if ($exception instanceof HttpException) {
      $this->render($exception);
    } else {
      $this->render(new HttpException(500, 0, null, array(), $exception));
    }
  }

  public function render(Exception $exception) {
    $outputMessage = Api_ApiErrorCode::getMessage($exception->getCode());
    if (!headers_sent()) {
      header("HTTP/1.1 " . $exception->getHttpStatusCode() . " " . $exception->getMessage());
      switch ($exception->getHttpStatusCode()) {
        case 301:
        case 303:
        case 307:
          header("Location: " . Api::app()->redirectUrl);
          break;
      }
    }
    if ($outputMessage) {
      echo json_encode($outputMessage);
    }
    Api::app()->end(1);
  }

}