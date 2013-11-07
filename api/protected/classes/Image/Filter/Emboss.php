<?php

class Image_Filter_Emboss extends Image_Filter_Filter {

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_EMBOSS;
    $this->args = array($this->im, $this->filter);
  }

}