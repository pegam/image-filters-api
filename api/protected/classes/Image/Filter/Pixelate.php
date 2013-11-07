<?php

class Image_Filter_Pixelate extends Image_Filter_Filter {

  const MIN_SIZE = 1;
  protected $size;

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_PIXELATE;
    if (!isset($this->size)) {
      throw new HttpException(400, 19);
    }
    if (!is_numeric($this->size)) {
      throw new HttpException(400, 19);
    }
    $this->size = (int) $this->size;
    if ($this->size < Image_Filter_Pixelate::MIN_SIZE) {
      throw new HttpException(400, 19);
    }
  }

  public function apply() {
    # apply filter
    Image_Filter_Pixelate::pixelate($this->im, $this->size);

    # create resulting image object
    $funcName = "image" . $this->dimage->getReturnImageType();
    if (!$funcName($this->im, $this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
  }

  public static function pixelate(&$im, $pix_size) {
    $width = imagesx($im);
    $height = imagesy($im);
    for ($x = 0; $x < $width; $x += $pix_size + 1) {
      for ($y = 0; $y < $height; $y += $pix_size + 1) {
        $rgb = imagecolorsforindex($im, imagecolorat($im, $x, $y));
        $color = imagecolorclosest($im, $rgb['red'], $rgb['green'], $rgb['blue']);
        imagefilledrectangle($im, $x, $y, $x + $pix_size, $y + $pix_size, $color);
      }
    }
  }

}