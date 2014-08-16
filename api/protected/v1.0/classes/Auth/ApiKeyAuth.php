<?php

class ApiKeyAuth {
//proba
  protected $clientId;
  protected $apiKey;

  public function __construct($clientId) {
    $this->clientId = $clientId;
  }

  public function check() {
    $hash = hash_hmac('sha1', Api::app()->request->getPathWithQuery(), $this->getApiKey(), true);
    $signature = base64_encode($hash);
    $signature = str_replace(array('+', '/'), array('-', '_'), $signature);
    if ($signature !== Api::app()->request->getSignature()) {
      throw new HttpException(401, 27);
    }
  }

  protected function getApiKey() {
    if (empty($this->apiKey)) {
      $this->apiKey = $this->fetchFromCache();
      if (!$this->apiKey) {
        $this->apiKey = $this->fetchFromFile();
        if (!$this->apiKey) {
          throw new ApiException();
        }
      }
    }
    return $this->apiKey;
  }

  protected function fetchFromCache() {
    return apc_fetch($this->clientId);
  }

  protected function fetchFromFile() {
    $ret = null;
    $f = fopen(Api::app()->apiKeysFile, 'r');
    if (!$f) {
      throw new ApiException();
    }
    while (!feof($f)) {
      $line = trim(fgets($f));
      if (!$line) {
        continue;
      }
      $parts = explode("\t", $line);
      apc_store($parts[0], $parts[1]);
      if ($parts[0] === $this->clientId) {
        $ret = $parts[1];
      }
    }
    fclose($f);
    return $ret;
  }

}

/*
 clientId - uniqid()
 apiKey - sha1(microtime(true).mt_rand(10000,90000))
*/