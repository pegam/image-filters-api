<?php

abstract class Image_ImageModel extends Model {

  protected $dimage;

  public function __construct(Image_DownloadedImage $dimage) {
    $this->dimage = $dimage;
  }

  abstract public function applyFilter();

}