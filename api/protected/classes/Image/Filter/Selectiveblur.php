<?php

class Image_Filter_Selectiveblur extends Image_Filter_Filter {

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_SELECTIVE_BLUR;
    $this->args = array($this->im, $this->filter);
  }

}