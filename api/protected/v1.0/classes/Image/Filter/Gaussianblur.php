<?php

class Image_Filter_Gaussianblur extends Image_Filter_AFilter {

  public function __construct($dimage, $imageObj, $args) {
    parent::__construct($dimage, $imageObj, $args);
    $this->filter = IMG_FILTER_GAUSSIAN_BLUR;
    $this->args = array($this->im, $this->filter);
  }

}