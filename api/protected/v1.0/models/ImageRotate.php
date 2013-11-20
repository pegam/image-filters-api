<?php

class ImageRotate extends Image_ImageModelDest {

  const COLOR_MIN = 0;
  const COLOR_MAX = 255;
  const ALPHA_MIN = 0;
  const ALPHA_MAX = 127;

  protected $angle;
  protected $bgred;
  protected $bggreen;
  protected $bgblue;
  protected $bgalpha;
  protected $dest_image_obj;

  public function __construct(Image_DownloadedImage $dimage, $angle, $bgred, $bggreen, $bgblue, $bgalpha) {
    $this->angle = $angle % 360;
    $this->bgred = $bgred;
    $this->bggreen = $bggreen;
    $this->bgblue = $bgblue;
    $this->bgalpha = $bgalpha;
  }

  public function apply() {
    if (!imagealphablending($this->dest_image_obj, false)) {
      throw new HttpException(500);
    }
    $this->dest_image_obj = imagerotate($this->image_obj,
                                        $this->angle,
                                        imagecolorallocatealpha($this->image_obj,
                                                                $this->bgred,
                                                                $this->bggreen,
                                                                $this->bgblue,
                                                                $this->bgalpha));
    if (!imagesavealpha($this->dest_image_obj, true)) {
      throw new HttpException(500);
    }
    $this->save();
  }

}