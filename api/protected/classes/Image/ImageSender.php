<?php

class Image_ImageSender {

  protected $fimage;

  public function __construct(Image_FilteredImage $fimage) {
    $this->fimage = $fimage;
  }

  public function send() {
    if (!headers_sent()) {
      $type = $this->fimage->getFileMimeType();
      $size = $this->fimage->getFileSize();
      if ($type && $size) {
        header(Http_HttpCode::getMessage(200));
        header('Content-Type: ' . $type);
        header('Content-Length: ' . $size);
        readfile($this->fimage->getFileLocation());
      }
    }
  }

}