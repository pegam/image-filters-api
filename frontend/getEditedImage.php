<?php

include 'protected/apiDomain.php';
include 'init.php';

if (empty($_GET) || empty($_GET['api_action']) || empty($_GET['url'])) {
  error('Params missing.', 'HTTP/1.1 400 Bad Request');
}

$currentDir = dirname(__FILE__);
$tmpfile = $currentDir . '/media/tmp/edit-img.' . uniqid() . '.tmp';

$url = buildUrl($apiDomain, $secure);

$fp = fopen($tmpfile, 'wb');
apiCurl($url, true, $fp);
fclose($fp);

$path = handleDownloadedImage($currentDir, $tmpfile, 'edited-img');

$ret = array('src' => $path);
success($ret);

function buildUrl($apiDomain, $secure) {
  $url = $apiDomain;
  $path = 'images/' . $_GET['api_action'];
  unset($_GET['api_action']);
  $path .= '?';
  foreach ($_GET as $k => $v) {
    $path .= "{$k}={$v}&";
  }
  $path = substr($path, 0, -1);
  if ($secure) {
    $url .= '/' . signature($path);
  }
  return "{$url}/{$path}";
}