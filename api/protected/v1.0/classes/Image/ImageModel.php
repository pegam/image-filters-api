<?php

abstract class Image_ImageModel extends Model {

  protected $dimage;
  protected $imageObj;

  public function __construct(Image_DownloadedImage $dimage) {
    $this->dimage = $dimage;
    # create starting image object
    $funcName = "imagecreatefrom{$this->dimage->getOrigImageType()}";
    $this->image_obj = $funcName($this->dimage->getLocalFileLocation());
    if (!$this->image_obj) {
      throw new HttpException(500);
    }
  }

  public function __destruct() {
    if ($this->image_obj) {
      imagedestroy($this->image_obj);
    }
    if (!isset($GLOBALS['image.filters.tmp.dirs']) || !in_array($this->dimage->getTempDir(), $GLOBALS['image.filters.tmp.dirs'])) {
      $GLOBALS['image.filters.tmp.dirs'][] = $this->dimage->getTempDir();
    }
  }

  abstract public function apply();

  public function save() {
    # create resulting image object
    $funcName = "image" . $this->dimage->getReturnImageType();
    if (!$funcName($this->image_obj, $this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
  }

  public function output() {
    if ($this->dimage->getReturnFileLocation() === null || !file_exists($this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
    $fimage = new Image_OutgoingImage($this->dimage);
    $sender = new Image_ImageSender($fimage);
    $sender->send();
    $GLOBALS['image.filters.tmp.dirs'][] = $this->dimage->getTempDir();
  }

}