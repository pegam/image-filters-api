<?php

class Image_Filter_Brightness extends Image_Filter_Filter {

  const MIN_BRIGHTNESS = -255;
  const MAX_BRIGHTNESS = 255;

  protected $level;

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_BRIGHTNESS;
    if (!isset($this->level)) {
      throw new HttpException(400, 15);
    }
    if (!is_numeric($this->level)) {
      throw new HttpException(400, 15);
    }
    $this->level = (int) $this->level;
    if ($this->level > Image_Filter_Brightness::MAX_BRIGHTNESS
            || $this->level < Image_Filter_Brightness::MIN_BRIGHTNESS) {
      throw new HttpException(400, 15);
    }
    $this->args = array($this->im, $this->filter, $this->level);
  }

}