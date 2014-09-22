<?php

class Image_ImageSender {

  protected $oimage;

  public function __construct(Image_OutgoingImage $fimage) {
    $this->oimage = $fimage;
  }

  public function send() {
    if (!headers_sent()) {
      $type = $this->oimage->getFileMimeType();
      $size = $this->oimage->getFileSize();
      if ($type && $size) {
        header(Http_HttpCode::getMessage(200));
        header('Content-Type: ' . $type);
        header('Content-Length: ' . $size);
        $filename = basename($this->oimage->getFileLocation());
        if ($filename) {
          header('Content-Disposition: inline; filename="' . $filename . '"');
          header('X-Filename: ' . $filename);
        }
        readfile($this->oimage->getFileLocation());
      }
    }
  }

}