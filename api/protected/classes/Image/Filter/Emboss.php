<?php

class Image_Filter_Emboss extends Image_Filter_Filter {

  public function __construct($dimage, $image_obj, $args) {
    parent::__construct($dimage, $image_obj, $args);
    $this->filter = IMG_FILTER_EMBOSS;
    $this->args = array($this->im, $this->filter);
  }

}