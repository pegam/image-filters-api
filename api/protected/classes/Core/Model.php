<?php

class Model {

  protected $out;

  public function output() {
    if (!headers_sent()) {
      header(Http_HttpCode::getMessage(200));
    }
    if (isset($this->out)) {
      echo json_encode($this->out);
    }
  }

}