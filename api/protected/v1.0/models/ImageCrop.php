<?php

class ImageCrop extends AImageCopy {

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
  }

  public function apply() {
    if (!imagealphablending($this->dest_image_obj, false)) {
      throw new HttpException(500);
    }
    if (!imagesavealpha($this->dest_image_obj, true)) {
      throw new HttpException(500);
    }
    if (!imagecopyresized($this->dest_image_obj, $this->image_obj, 0, 0, $this->orig_xpoint, $this->orig_ypoint, $this->new_hsize, $this->new_vsize, $this->new_hsize, $this->new_vsize)) {
      throw new HttpException(500);
    }
    $this->save();
  }

}