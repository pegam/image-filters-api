<?php

class Image_Filter_Negate extends Image_Filter_AFilter {

  public function __construct($dimage, $imageObj, $args) {
    parent::__construct($dimage, $imageObj, $args);
    $this->filter = IMG_FILTER_NEGATE;
    $this->args = array($this->im, $this->filter);
  }

}