<?php

class ImageResize extends AImageCopy {

  public function __construct(Image_DownloadedImage $dimage, $hsize, $vsize, $resample = false) {
    if (!$hsize && !$vsize) {
      throw new HttpException(400, 20);
    }
    parent::__construct($dimage, 0, 0, $hsize, $vsize, $resample);
  }

}