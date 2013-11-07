<?php

class Image_Filter_Colorize extends Image_Filter_Filter {

  const MIN_COLOR_COLORIZE = -255;
  const MAX_COLOR_COLORIZE = 255;
  const MIN_ALPHA_COLORIZE = 0;
  const MAX_ALPHA_COLORIZE = 127;

  protected $red;
  protected $green;
  protected $blue;
  protected $alpha;

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_COLORIZE;
    if (!isset($this->red) || !isset($this->green)
            || !isset($this->blue) || !isset($this->alpha)) {
      throw new HttpException(400, 17);
    }
    if (!is_numeric($this->red) || !is_numeric($this->green)
            || !is_numeric($this->blue) || !is_numeric($this->alpha)) {
      throw new HttpException(400, 17);
    }
    $this->red = (int) $this->red;
    $this->blue = (int) $this->blue;
    $this->green = (int) $this->green;
    $this->alpha = (int) $this->alpha;
    if ($this->red > Image_Filter_Colorize::MAX_COLOR_COLORIZE
            || $this->red < Image_Filter_Colorize::MIN_COLOR_COLORIZE) {
      throw new HttpException(400, 17);
    }
    if ($this->blue > Image_Filter_Colorize::MAX_COLOR_COLORIZE
            || $this->blue < Image_Filter_Colorize::MIN_COLOR_COLORIZE) {
      throw new HttpException(400, 17);
    }
    if ($this->green > Image_Filter_Colorize::MAX_COLOR_COLORIZE
            || $this->green < Image_Filter_Colorize::MIN_COLOR_COLORIZE) {
      throw new HttpException(400, 17);
    }
    if ($this->alpha > Image_Filter_Colorize::MAX_ALPHA_COLORIZE
            || $this->alpha < Image_Filter_Colorize::MIN_ALPHA_COLORIZE) {
      throw new HttpException(400, 17);
    }
    $this->args = array($this->im, $this->filter, $this->red, $this->green, $this->blue, $this->alpha);
  }

}