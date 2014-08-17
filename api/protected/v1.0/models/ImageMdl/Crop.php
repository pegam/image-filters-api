<?php

class ImageMdl_Crop extends ImageMdl_ACopy {

  public function __construct(Image_DownloadedImage $dimage, $xpoint, $ypoint, $hsize, $vsize) {
    if ((!$hsize && !$vsize) || $xpoint < 0 || $ypoint < 0) {
      throw new HttpException(400, 21);
    }
    parent::__construct($dimage, $xpoint, $ypoint, $hsize, $vsize);
    if ($this->orig_xpoint > $this->orig_hsize
            || $this->orig_ypoint > $this->orig_vsize
            || $this->orig_xpoint + $this->new_vsize > $this->orig_vsize
            || $this->orig_ypoint + $this->new_hsize > $this->orig_hsize) {
      throw new HttpException(400, 22);
    }
    $this->orig_hsize = $this->new_hsize;
    $this->orig_vsize = $this->new_vsize;
  }

}