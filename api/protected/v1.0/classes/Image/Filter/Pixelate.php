<?php

class Image_Filter_Pixelate extends Image_Filter_Filter {

  const MIN_SIZE = 1;
  protected $size;

  public function __construct($dimage, $imageObj, $args) {
    parent::__construct($dimage, $imageObj, $args);
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
    Image_Filter_Pixelate::pixelate($this->im, $this->size);
  }

  public static function pixelate(&$im, $pixSize) {
    $width = imagesx($im);
    $height = imagesy($im);
    for ($x = 0; $x < $width; $x += $pixSize + 1) {
      for ($y = 0; $y < $height; $y += $pixSize + 1) {
        $rgb = imagecolorsforindex($im, imagecolorat($im, $x, $y));
        $color = imagecolorclosest($im, $rgb['red'], $rgb['green'], $rgb['blue']);
        imagefilledrectangle($im, $x, $y, $x + $pixSize, $y + $pixSize, $color);
      }
    }
  }

}