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
        $this->origXpoint = $this->origHsize - 1;
        $this->origHsize = -$this->origHsize;
        break;
      case ImageMdl_Flip::FLIP_VERTICAL:
        $this->origYpoint = $this->origVsize - 1;
        $this->origVsize = -$this->origVsize;
        break;
      case ImageMdl_Flip::FLIP_BOTH:
        $this->origXpoint = $this->origHsize - 1;
        $this->origHsize = -$this->origHsize;
        $this->origYpoint = $this->origVsize - 1;
        $this->origVsize = -$this->origVsize;
        break;
    }
  }

  public function apply() {
    if (!imagealphablending($this->destImageObj, false)) {
      throw new HttpException(500);
    }
    if (!imagesavealpha($this->destImageObj, true)) {
      throw new HttpException(500);
    }
    if (!imagecopyresampled($this->destImageObj, $this->imageObj, 0, 0, $this->origXpoint, $this->origYpoint, $this->newHsize, $this->newVsize, $this->origHsize, $this->origVsize)) {
      throw new HttpException(500);
    }
    $this->save();
  }

}