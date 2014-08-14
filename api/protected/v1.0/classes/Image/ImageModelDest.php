<?php

abstract class Image_ImageModelDest extends Image_ImageModel {

  protected $dimage;
  protected $imageObj;
  protected $destImageObj;

  public function __destruct() {
    if ($this->destImageObj) {
      imagedestroy($this->destImageObj);
    }
    parent::__destruct();
  }

  public function save() {
    # create resulting image object
    $funcName = "image" . $this->dimage->getReturnImageType();
    if (!$funcName($this->destImageObj, $this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
  }

}