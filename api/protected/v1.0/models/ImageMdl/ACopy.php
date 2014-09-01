<?php

abstract class ImageMdl_ACopy extends Image_AImageModelDest {

  const HORIZONTAL = 1;
  const VERTICAL = 2;

  protected $origXpoint;
  protected $origYpoint;
  protected $origHsize;
  protected $origVsize;
  protected $newHsize;
  protected $newVsize;
  protected $resample;

  public function __construct(Image_DownloadedImage $dimage, $xpoint, $ypoint, $hsize, $vsize, $resample = false) {
    parent::__construct($dimage);
    if (!$hsize && !$vsize) {
      throw new HttpException(500);
    }
    $imgInfo = $dimage->getOrigImageInfo();
    $this->origHsize = (int) $imgInfo[0];
    $this->origVsize = (int) $imgInfo[1];
    $this->origXpoint = $xpoint;
    $this->origYpoint = $ypoint;
    if ($hsize) {
      $this->newHsize = $hsize;
    } else {
      $this->newHsize = $this->getSize($vsize, ImageMdl_Resize::HORIZONTAL);
    }
    if ($vsize) {
      $this->newVsize = $vsize;
    } else {
      $this->newVsize = $this->getSize($hsize, ImageMdl_Resize::VERTICAL);
    }
    $this->resample = $resample;

    $this->destImageObj = imagecreatetruecolor($this->newHsize, $this->newVsize);
    if (!$this->destImageObj) {
      throw new HttpException(500);
    }
  }

  public function apply() {
    if (!imagealphablending($this->destImageObj, false)) {
      throw new HttpException(500);
    }
    if (!imagesavealpha($this->destImageObj, true)) {
      throw new HttpException(500);
    }
    if ($this->resample) {
      if (!imagecopyresampled($this->destImageObj, $this->imageObj, 0, 0, $this->origXpoint, $this->origYpoint, $this->newHsize, $this->newVsize, $this->origHsize, $this->origVsize)) {
        throw new HttpException(500);
      }
    } else {
      if (!imagecopyresized($this->destImageObj, $this->imageObj, 0, 0, $this->origXpoint, $this->origYpoint, $this->newHsize, $this->newVsize, $this->origHsize, $this->origVsize)) {
        throw new HttpException(500);
      }
    }
    $this->save();
  }

  protected function getSize($size, $mode) {
    $prop = $this->origHsize / $this->origVsize;
    switch ($mode) {
      case ImageMdl_Resize::HORIZONTAL:
        return (int) ($size * $prop);
      case ImageMdl_Resize::VERTICAL:
        return (int) ($size / $prop);
    }
    throw new HttpException(500);
  }

}