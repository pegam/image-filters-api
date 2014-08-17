<?php

class Image_DownloadedImage {

  protected $tempDir;
  protected $origFilename;
  protected $localFileLoc;
  protected $localImageSize;
  protected $origImageType;
  protected $returnImageType;
  protected $returnFilename;
  protected $returnFileLoc;

  public function __construct() {
    $this->initTempDir();
    if (Api::app()->request->getHttpMethod() === 'GET') {
      $this->doGet();
    } else if (Api::app()->request->getHttpMethod() === 'POST') {
      $this->doPost();
    }
    $this->localImageSize = getimagesize($this->localFileLoc);
    if (!$this->localImageSize) {
      throw new HttpException(400, 13);
    }
    $this->init();
  }

  private  function doGet() {
    if (!isset($_GET['url'])) {
      throw new HttpException(400, 11);
    }
    $imgUrlParsed = parse_url($_GET['url']);
    $this->origFilename = basename($imgUrlParsed['path']);
    $this->localFileLoc = $this->tempDir . '/' . uniqid();
    $maxSize = $this->getMaxDownloadSize();
    $remoteImgSize = $this->getContentLength();
    if ($remoteImgSize > $maxSize) {
      throw new HttpException(400, 11);
    }
    $this->download();
  }

  private function doPost() {
    if (isset($_GET['url'])) {
      $this->doGet();
    } else {
      if (!$_FILES) {
        throw new HttpException(400, 10);
      }
      $filesArrElement = reset($_FILES);
      if (!$filesArrElement['tmp_name']) {
        throw new HttpException(400, 10);
      }
      $this->origFilename = $filesArrElement['name'];
      $this->localFileLoc = $this->tempDir . '/' . basename($filesArrElement['tmp_name']);
      if (!rename($filesArrElement['tmp_name'], $this->localFileLoc)) {
        throw new HttpException(500);
      }
    }
  }

  private function init() {
    $this->origImageType = image_type_to_extension($this->localImageSize[2], false);
    $this->returnImageType = $this->origImageType;
    if (isset($_GET['out'])) {
      $out = strtolower($_GET['out']);
      if ($out === 'jpg') {
        $out = 'jpeg';
      }
      $ok = false;
      foreach (Api::app()->awailableImageFormats as $code) {
        $ext = image_type_to_extension($code, false);
        if ($ext === $out) {
          $ok = true;
          break;
        }
      }
      if (!$ok) {
        throw new HttpException(400, 14);
      }
      $this->returnImageType = $out;
    }
    $pattern = '/\.' . $this->origImageType . '$/i';
    if ($this->origImageType === 'jpeg') {
      $pattern = '/\.jpe?g$/i';
    }
    $this->returnFilename = preg_replace($pattern, '', $this->origFilename). '.' . $this->returnImageType;
    $path = dirname($this->localFileLoc);
    $this->returnFileLoc = $path . '/' . $this->returnFilename;
  }

  protected function initTempDir() {
    if (Api::app()->environment === 'production') {
      $this->tempDir = $_SERVER['DOCUMENT_ROOT'] . '/temporary' . '/imagefilters.' . getmypid() . uniqid('.', true);
    } else {
      $this->tempDir = sys_get_temp_dir() . '/imagefilters.' . getmypid() . uniqid('.', true);
    }
    if (file_exists($this->tempDir)) {
      throw new HttpException(500);
    }
    if (!mkdir($this->tempDir) || !file_exists($this->tempDir)) {
      throw new HttpException(500);
    }
  }

  protected function getContentLength() {
    $ch = curl_init($_GET['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $ret = curl_exec($ch);
    $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    curl_close($ch);
    if ($ret === false) {
      throw new HttpException(500);
    }
    return $size;
  }

  protected function download() {
    $fp = fopen($this->localFileLoc, 'wb');
    if (!$fp) {
      throw new HttpException(500);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_GET['url']);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $ret = curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    if ($ret === false) {
      throw new HttpException(500);
    }
  }

  public function getMaxDownloadSize() {
    $maxsize = ini_get('upload_max_filesize');
    if (!$maxsize) {
      $maxsize = ini_get('post_max_size');
      if (!$maxsize) {
        throw new HttpException(500);
      }
    }
    $val = trim($maxsize);
    $last = strtolower($val[strlen($val) - 1]);
    switch($last) {
      case 'g':
        $val *= 1024;
      case 'm':
        $val *= 1024;
      case 'k':
        $val *= 1024;
    }
    return $val;
  }

  public function getTempDir() {
    return $this->tempDir;
  }

  public function getLocalFileLocation() {
    return isset($this->localFileLoc) ? $this->localFileLoc : null;
  }

  public function getOrigImageType() {
    return $this->origImageType;
  }

  public function getReturnImageType() {
    return $this->returnImageType;
  }

  public function getReturnFileLocation() {
    return isset($this->returnFileLoc) ? $this->returnFileLoc : null;
  }

  public function getOrigImageInfo() {
    return $this->localImageSize;
  }

}