<?php

class ImageMdl_Filter extends Image_AImageModel {

  protected $filter;

  public function __construct(Image_DownloadedImage $dimage, $filter, $filterArgs) {
    parent::__construct($dimage);
    $filterClassName = "Image_Filter_" .  ucfirst($filter);
    $this->filter = new $filterClassName($this->dimage, $this->imageObj, $filterArgs);
  }

  public function apply() {
    $this->filter->apply();
    $this->save();
  }

}