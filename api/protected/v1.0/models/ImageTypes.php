<?php

class ImageTypes extends Model {

  public function getTypes() {
    $this->out = array();
    foreach (Api::app()->awailableImageFormats as $code) {
      $this->out[] = image_type_to_extension($code, false);
    }
  }

}