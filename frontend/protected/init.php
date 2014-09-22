<?php

header('HTTP/1.1 500 Internal Server Error');

$secure = false;

function signature(&$pathWithQuery) {
  $clientId = '53ecca8609d14';
  $apiKey = 'ddc366b21106b13347e9cba8e63056370735072e';
  $pathWithQuery = ltrim($pathWithQuery, '/');
  if (strpos($pathWithQuery, "client={$clientId}") === false) {
    if (strpos($pathWithQuery, '?') === false) {
      $pathWithQuery .= '?';
    } else {
      $pathWithQuery .= '&';
    }
    $pathWithQuery .= "client={$clientId}";
  }
  $hash = hash_hmac('sha1', $pathWithQuery, $apiKey, true);
  $signature = base64_encode($hash);
  $signature = str_replace(array('+', '/'), array('-', '_'), $signature);
  return $signature;
}

function apiCurl($url, $post = false, &$fp = null) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if ($post) {
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  }
  $response = curl_exec($ch);
  $return = explode("\r\n\r\n", $response, 2);
  $return = array_pop($return);
  $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($responseCode !== 200) {
    error("api response code: {$responseCode}");
  }
  if ($fp !== null) {
    fwrite($fp, $return);
    return null;
  }
  return $return;
}

function error($txt = null, $header = null, $exit = true) {
  if (!headers_sent() && $header) {
    header($header);
  }
  if ($txt) {
    echo $txt;
  }
  if ($exit) {
    exit();
  }
}

function success($ret = '') {
  if (!headers_sent()) {
    header('HTTP/1.1 200 OK');
  }
  if (!is_string($ret)) {
    $ret = json_encode($ret);
  }
  echo $ret;
  exit();
}

function handleDownloadedImage($baseDir, $tmpfile, $name) {
  $ext = getExtension($tmpfile);
  $hash = sha1_file($tmpfile);
  $path = "/media/tmp/{$hash}/{$name}.{$ext}";
  if (!file_exists($baseDir . "/media/tmp/{$hash}")) {
    mkdir($baseDir . "/media/tmp/{$hash}");
  }
  rename($tmpfile, $baseDir . $path);
  if (file_exists($tmpfile)) {
    unlink($tmpfile);
  }
  return $path;
}

function getExtension($file) {
  $arr = getimagesize($file);
  if (!$arr) {
    unlink($file);
    error('Bad url.', 'HTTP/1.1 400 Bad Request');
  }
  return image_type_to_extension($arr[2], false);
}