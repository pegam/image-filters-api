<?php

class Image_OutgoingImage {

  private $dimage;
  protected $fileLoc;
  protected $imageWidth;
  protected $imageHeight;
  protected $imageType;
  protected $fileMimeType;
  protected $fileSize;

  public function __construct(Image_DownloadedImage $dimage) {
    $this->dimage = $dimage;
    $this->fileLoc = $dimage->getReturnFileLocation();
    $imageInfo = getimagesize($this->fileLoc);
    $this->imageWidth = $imageInfo[0];
    $this->imageHeight = $imageInfo[1];
    $this->imageType = $imageInfo[2];
    $this->fileMimeType = $imageInfo['mime'];
    $this->fileSize = filesize($this->fileLoc);
  }

  public function getFileMimeType() {
    return $this->fileMimeType;
  }

  public function getFileSize() {
    return $this->fileSize;
  }

  public function getFileLocation() {
    return $this->fileLoc;
  }

}