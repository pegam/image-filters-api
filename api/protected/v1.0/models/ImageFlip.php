<?php

class ImageFlip extends AImageCopy {

  const FLIP_HORIZONTAL = 'horizontal';
  const FLIP_VERTICAL = 'vertical';
  const FLIP_BOTH = 'both';

  public function __construct(Image_DownloadedImage $dimage, $direction, $resample = false) {
    parent::__construct($dimage, 0, 0, $hsize, $vsize, $resample);
    switch ($direction) {
      case ImageFlip::FLIP_HORIZONTAL:
        $this->orig_xpoint = $this->orig_hsize - 1;
        $this->orig_hsize = -$this->orig_hsize;
        break;
      case ImageFlip::FLIP_VERTICAL:
        $this->orig_ypoint = $this->orig_vsize - 1;
        $this->orig_vsize = -$this->orig_vsize;
        break;
      case ImageFlip::FLIP_BOTH:
        $this->orig_xpoint = $this->orig_hsize - 1;
        $this->orig_hsize = -$this->orig_hsize;
        $this->orig_ypoint = $this->orig_vsize - 1;
        $this->orig_vsize = -$this->orig_vsize;
        break;
    }
  }

}