<?php

class Image_Filter_Grayscale extends Image_Filter_AFilter {

  public function __construct($dimage, $imageObj, $args) {
    parent::__construct($dimage, $imageObj, $args);
    $this->filter = IMG_FILTER_GRAYSCALE;
    $this->args = array($this->im, $this->filter);
  }

}