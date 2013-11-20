<?php

class ImageFitIn extends AImageCopy {

  public function __construct(Image_DownloadedImage $dimage, $hsize, $vsize, $resample = false) {
    if (!$hsize && !$vsize) {
      throw new HttpException(400, 23);
    }
    if (!$hsize) {
      parent::__construct($dimage, 0, 0, null, $vsize, $resample);
    } else if (!$vsize) {
      parent::__construct($dimage, 0, 0, $hsize, null, $resample);
    } else {
      $new_prop = $hsize / $vsize;
      $imgInfo = $dimage->getOrigImageInfo();
      $orig_prop = ((int) $imgInfo[0])/ ((int) $imgInfo[1]);
      if ($new_prop > $orig_prop) {
        parent::__construct($dimage, 0, 0, null, $vsize, $resample);
      } else if ($new_prop < $orig_prop) {
        parent::__construct($dimage, 0, 0, $hsize, null, $resample);
      } else {
        parent::__construct($dimage, 0, 0, $hsize, $vsize, $resample);
      }
    }
  }

}