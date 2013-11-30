<?php

class Image_Filter_Filter {

  protected $dimage;
  protected $im;
  protected $filter;
  protected $args;

  public function __construct($dimage, $image_obj, $args) {
    $this->dimage = $dimage;
    $this->im = $image_obj;

    foreach ($args as $name => $value) {
      if (property_exists($this, $name)) {
        $this->$name = $value;
      }
    }
  }

  public function apply() {
    $r = call_user_func_array('imagefilter', $this->args);
    if ($r !== true) {
      throw new HttpException(500);
    }
  }

  public function getFilterName() {
    return strtolower(substr(get_class($this), 0, strlen('Image_Filter_')));
  }

}