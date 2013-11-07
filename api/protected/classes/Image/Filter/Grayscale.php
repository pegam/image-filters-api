<?php

class Image_Filter_Grayscale extends Image_Filter_Filter {

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_GRAYSCALE;
    $this->args = array($this->im, $this->filter);
  }

}