<?php

class Image_Filter_Smooth extends Image_Filter_Filter {

  protected $level;

  public function __construct($dimage, $image_obj, $args) {
    parent::__construct($dimage, $image_obj, $args);
    $this->filter = IMG_FILTER_SMOOTH;
    if (!isset($this->level)) {
      throw new HttpException(400, 18);
    }
    if (!is_numeric($this->level)) {
      throw new HttpException(400, 18);
    }
    $this->level = (float) $this->level;
    $this->args = array($this->im, $this->filter, $this->level);
  }

}