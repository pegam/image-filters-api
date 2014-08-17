<?php

class Image_Filter_Contrast extends Image_Filter_AFilter {

  const MIN_CONTRAST = 100;
  const MAX_CONTRAST = -100;

  protected $level;

  public function __construct($dimage, $imageObj, $args) {
    parent::__construct($dimage, $imageObj, $args);
    $this->filter = IMG_FILTER_CONTRAST;
    if (!isset($this->level)) {
      throw new HttpException(400, 16);
    }
    if (!is_numeric($this->level)) {
      throw new HttpException(400, 16);
    }
    $this->level = (int) $this->level;
    if ($this->level < Image_Filter_Contrast::MAX_CONTRAST
            || $this->level > Image_Filter_Contrast::MIN_CONTRAST) {
      throw new HttpException(400, 16);
    }
    $this->args = array($this->im, $this->filter, $this->level);
  }

}