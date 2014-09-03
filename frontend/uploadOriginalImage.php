<?php

include 'init.php';

$currentDir = dirname(__FILE__);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  handleGet($currentDir);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  handlePost($currentDir);
} else {
  error('Wrong request method.', 'HTTP/1.1 400 Bad Request');
}

function handleGet($currentDir) {
  if (empty($_GET['url'])) {
    error('Url missing.', 'HTTP/1.1 400 Bad Request');
  }

  $url = trim($_GET['url']);
  $tmpfile = $currentDir . '/media/tmp/orig-img.' . uniqid() . '.tmp';

  $fp = fopen($tmpfile, 'wb');
  apiCurl($url, false, $fp);
  fclose($fp);

  $path = handleDownloadedImage($currentDir, $tmpfile, 'original-img');

  $ret = array('src' => $path);
  success($ret);
}

function handlePost($currentDir) {
  if (!$_FILES) {
    error('Uploaded file missing.', 'HTTP/1.1 400 Bad Request');
  }

  $filesArrElement = reset($_FILES);
  if (!$filesArrElement['tmp_name']) {
    error('Uploaded file missing.', 'HTTP/1.1 400 Bad Request');
  }

  $tmpfile = $currentDir . '/media/tmp/orig-img.' . uniqid() . '.tmp';
  rename($filesArrElement['tmp_name'], $tmpfile);

  $path = handleDownloadedImage($currentDir, $tmpfile, 'original-img');

  $ret = array('src' => $path);
  success($ret);
}