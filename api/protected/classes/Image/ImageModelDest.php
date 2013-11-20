<?php

abstract class Image_ImageModelDest extends Image_ImageModel {

  protected $dimage;
  protected $image_obj;
  protected $dest_image_obj;

  public function __destruct() {
    if ($this->dest_image_obj) {
      imagedestroy($this->dest_image_obj);
    }
    parent::__destruct();
  }

  public function save() {
    # create resulting image object
    $funcName = "image" . $this->dimage->getReturnImageType();
    if (!$funcName($this->dest_image_obj, $this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
  }

}