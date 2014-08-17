<?php

class ImageMdl_Flip extends ImageMdl_ACopy {

  const FLIP_HORIZONTAL = 'horizontal';
  const FLIP_VERTICAL = 'vertical';
  const FLIP_BOTH = 'both';

  public function __construct(Image_DownloadedImage $dimage, $direction) {
    $imgInfo = $dimage->getOrigImageInfo();
    parent::__construct($dimage, 0, 0, (int) $imgInfo[0], (int) $imgInfo[1]);
    switch ($direction) {
      case ImageMdl_Flip::FLIP_HORIZONTAL:
        $this->orig_xpoint = $this->orig_hsize - 1;
        $this->orig_hsize = -$this->orig_hsize;
        break;
      case ImageMdl_Flip::FLIP_VERTICAL:
        $this->orig_ypoint = $this->orig_vsize - 1;
        $this->orig_vsize = -$this->orig_vsize;
        break;
      case ImageMdl_Flip::FLIP_BOTH:
        $this->orig_xpoint = $this->orig_hsize - 1;
        $this->orig_hsize = -$this->orig_hsize;
        $this->orig_ypoint = $this->orig_vsize - 1;
        $this->orig_vsize = -$this->orig_vsize;
        break;
    }
  }

  public function apply() {
    if (!imagealphablending($this->dest_image_obj, false)) {
      throw new HttpException(500);
    }
    if (!imagesavealpha($this->dest_image_obj, true)) {
      throw new HttpException(500);
    }
    if (!imagecopyresampled($this->dest_image_obj, $this->image_obj, 0, 0, $this->orig_xpoint, $this->orig_ypoint, $this->new_hsize, $this->new_vsize, $this->orig_hsize, $this->orig_vsize)) {
      throw new HttpException(500);
    }
    $this->save();
  }

}