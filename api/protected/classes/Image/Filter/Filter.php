<?php

class Image_Filter_Filter {

  protected $dimage;
  protected $im;
  protected $filter;
  protected $args;

  public function __construct($dimage, $args) {
    $this->dimage = $dimage;
    # create starting image object
    $funcName = "imagecreatefrom{$this->dimage->getOrigImageType()}";
    $this->im = $funcName($this->dimage->getLocalFileLocation());
    if (!$this->im) {
      throw new HttpException(500);
    }

    foreach ($args as $name => $value) {
      if (property_exists($this, $name)) {
        $this->$name = $value;
      }
    }
  }

  public function __destruct() {
    if ($this->im) {
      imagedestroy($this->im);
    }
    if (!isset($GLOBALS['image.filters.tmp.dirs']) || !in_array($this->dimage->getTempDir(), $GLOBALS['image.filters.tmp.dirs'])) {
      $GLOBALS['image.filters.tmp.dirs'][] = $this->dimage->getTempDir();
    }
  }

  public function apply() {
    # apply filter
    $r = call_user_func_array('imagefilter', $this->args);
    if ($r !== true) {
      throw new HttpException(500);
    }

    # create resulting image object
    $funcName = "image" . $this->dimage->getReturnImageType();
    if (!$funcName($this->im, $this->dimage->getReturnFileLocation())) {
      throw new HttpException(500);
    }
  }

  public function getFilterName() {
    return strtolower(substr(get_class($this), 0, strlen('Image_Filter_')));
  }

}