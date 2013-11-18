<?php

class Image_Filter_Edgedetect extends Image_Filter_Filter {

  public function __construct($dimage, $image_obj, $args) {
    parent::__construct($dimage, $image_obj, $args);
    $this->filter = IMG_FILTER_EDGEDETECT;
    $this->args = array($this->im, $this->filter);
  }

}