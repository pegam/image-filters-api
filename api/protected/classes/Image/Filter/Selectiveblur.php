<?php

class Image_Filter_Selectiveblur extends Image_Filter_Filter {

  public function __construct($dimage, $image_obj, $args) {
    parent::__construct($dimage, $image_obj, $args);
    $this->filter = IMG_FILTER_SELECTIVE_BLUR;
    $this->args = array($this->im, $this->filter);
  }

}