<?php

class Image_Filter_Edgedetect extends Image_Filter_Filter {

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_EDGEDETECT;
    $this->args = array($this->im, $this->filter);
  }

}