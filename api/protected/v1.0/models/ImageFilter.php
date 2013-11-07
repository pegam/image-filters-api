<?php

class ImageFilter extends Image_ImageModel {

  protected $filter;

  public function __construct(Image_DownloadedImage $dimage, $filter, $filterArgs) {
    parent::__construct($dimage);
    $filterClassName = "Image_Filter_" .  ucfirst($filter);
    $this->filter = new $filterClassName($this->dimage, $filterArgs);
  }

  public function applyFilter() {
    $this->filter->apply();
  }

  public function output() {
    if ($this->dimage->getReturnFileLocation() === null || !file_exists($this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
    $fimage = new Image_FilteredImage($this->dimage);
    $sender = new Image_ImageSender($fimage);
    $sender->send();
    $GLOBALS['image.filters.tmp.dirs'][] = $this->dimage->getTempDir();
  }

}