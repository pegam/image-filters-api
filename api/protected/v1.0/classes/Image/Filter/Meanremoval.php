<?php

class Image_Filter_Meanremoval extends Image_Filter_AFilter {

  public function __construct($dimage, $imageObj, $args) {
    parent::__construct($dimage, $imageObj, $args);
    $this->filter = IMG_FILTER_MEAN_REMOVAL;
    $this->args = array($this->im, $this->filter);
  }

}