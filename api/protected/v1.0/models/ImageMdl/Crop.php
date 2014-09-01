<?php

class ImageMdl_Crop extends ImageMdl_ACopy {

  public function __construct(Image_DownloadedImage $dimage, $xpoint, $ypoint, $hsize, $vsize) {
    if ((!$hsize && !$vsize) || $xpoint < 0 || $ypoint < 0) {
      throw new HttpException(400, 21);
    }
    parent::__construct($dimage, $xpoint, $ypoint, $hsize, $vsize);
    if ($this->origXpoint > $this->origHsize
            || $this->origYpoint > $this->origVsize
            || $this->origXpoint + $this->newVsize > $this->origVsize
            || $this->origYpoint + $this->newHsize > $this->origHsize) {
      throw new HttpException(400, 22);
    }
    $this->origHsize = $this->newHsize;
    $this->origVsize = $this->newVsize;
  }

}