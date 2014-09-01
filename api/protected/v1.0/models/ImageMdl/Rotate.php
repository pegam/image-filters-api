<?php

class ImageMdl_Rotate extends Image_AImageModelDest {

  const COLOR_MIN = 0;
  const COLOR_MAX = 255;
  const ALPHA_MIN = 0;
  const ALPHA_MAX = 127;

  protected $angle;
  protected $bgred;
  protected $bggreen;
  protected $bgblue;
  protected $bgalpha;

  public function __construct(Image_DownloadedImage $dimage, $angle, $bgred, $bggreen, $bgblue, $bgalpha) {
    parent::__construct($dimage);

    $this->angle = fmod($angle, 360);
    $this->bgred = $bgred;
    $this->bggreen = $bggreen;
    $this->bgblue = $bgblue;
    $this->bgalpha = $bgalpha;
  }

  public function apply() {
    $this->destImageObj = imagerotate($this->imageObj,
                                      $this->angle,
                                      imagecolorallocatealpha($this->imageObj,
                                                              $this->bgred,
                                                              $this->bggreen,
                                                              $this->bgblue,
                                                              $this->bgalpha));
    if (!imagealphablending($this->destImageObj, false)) {
      throw new HttpException(500);
    }
    if (!imagesavealpha($this->destImageObj, true)) {
      throw new HttpException(500);
    }
    $this->save();
  }

}