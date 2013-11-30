<?php

class Image_Filter_Pixelate extends Image_Filter_Filter {

  const MIN_SIZE = 1;
  protected $size;

  public function __construct($dimage, $image_obj, $args) {
    parent::__construct($dimage, $image_obj, $args);
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