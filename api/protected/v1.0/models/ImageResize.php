<?php

class ImageResize extends Image_ImageModel {

  const HORIZONTAL = 1;
  const VERTICAL = 2;

  protected $orig_hsize;
  protected $orig_vsize;
  protected $new_hsize;
  protected $new_vsize;
  protected $resample;
  protected $dest_image_obj;

  public function __construct(Image_DownloadedImage $dimage, $hsize, $vsize, $resample = false) {
    parent::__construct($dimage);
    if (!$hsize && !$vsize) {
      throw new HttpException(400, 20, null, array('{action}' => 'resize'));
    }
    $imgInfo = $dimage->getOrigImageInfo();
    $this->orig_hsize = (int) $imgInfo[0];
    $this->orig_vsize = (int) $imgInfo[1];
    if ($hsize) {
      $this->new_hsize = $hsize;
    } else {
      $this->new_hsize = $this->getSize($vsize, ImageResize::HORIZONTAL);
    }
    if ($vsize) {
      $this->new_vsize = $vsize;
    } else {
      $this->new_vsize = $this->getSize($hsize, ImageResize::VERTICAL);
    }
    $this->resample = $resample;

    $this->dest_image_obj = imagecreatetruecolor($this->new_hsize, $this->new_vsize);
    if (!$this->dest_image_obj) {
      throw new HttpException(500);
    }
  }

  public function __destruct() {
    if ($this->dest_image_obj) {
      imagedestroy($this->dest_image_obj);
    }
    parent::__destruct();
  }

  public function apply() {
    if (!imagealphablending($this->dest_image_obj, false)) {
      throw new HttpException(500);
    }
    if (!imagesavealpha($this->dest_image_obj, true)) {
      throw new HttpException(500);
    }
    if ($this->resample) {
      if (!imagecopyresampled($this->dest_image_obj, $this->image_obj, 0, 0, 0, 0, $this->new_hsize, $this->new_vsize, $this->orig_hsize, $this->orig_vsize)) {
        throw new HttpException(500);
      }
    } else {
      if (!imagecopyresized($this->dest_image_obj, $this->image_obj, 0, 0, 0, 0, $this->new_hsize, $this->new_vsize, $this->orig_hsize, $this->orig_vsize)) {
        throw new HttpException(500);
      }
    }
    $this->save();
  }

  public function save() {
    # create resulting image object
    $funcName = "image" . $this->dimage->getReturnImageType();
    if (!$funcName($this->dest_image_obj, $this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
  }

  protected function getSize($size, $mode) {
    $prop = $this->orig_hsize / $this->orig_vsize;
    switch ($mode) {
      case ImageResize::HORIZONTAL:
        return (int) ($size * $prop);
      case ImageResize::VERTICAL:
        return (int) ($size / $prop);
    }
    throw new HttpException(500);
  }

}