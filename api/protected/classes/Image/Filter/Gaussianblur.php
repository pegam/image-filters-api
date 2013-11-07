<?php

class Image_Filter_Gaussianblur extends Image_Filter_Filter {

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_GAUSSIAN_BLUR;
    $this->args = array($this->im, $this->filter);
  }

}