<?php

class Image_Filter_Meanremoval extends Image_Filter_Filter {

  public function __construct($dimage, $args) {
    parent::__construct($dimage, $args);
    $this->filter = IMG_FILTER_MEAN_REMOVAL;
    $this->args = array($this->im, $this->filter);
  }

}