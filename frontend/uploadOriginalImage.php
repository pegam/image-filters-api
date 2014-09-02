<?php

header('HTTP/1.1 400 Bad Request');

if (empty($_GET['url'])) {
  error('Url missing.');
}

$currentDir = dirname(__FILE__);
$url = trim($_GET['url']);
$tmpfile = $currentDir . '/media/tmp/img.' . uniqid() . '.tmp';

$ch = curl_init($url);
$fp = fopen($tmpfile, 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

$ext = getExtension($tmpfile);
$hash = sha1_file($tmpfile);
$name = 'original-img';
$path = "/media/tmp/{$hash}/{$name}.{$ext}";
if (!file_exists($currentDir . "/media/tmp/{$hash}")) {
  mkdir($currentDir . "/media/tmp/{$hash}");
  rename($tmpfile, $currentDir . $path);
}
unlink($tmpfile);

$ret = array('src' => $path);
if (!headers_sent()) {
  header('HTTP/1.1 200 OK');
}
echo json_encode($ret);
exit();


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

function getExtension($file) {
  $arr = getimagesize($file);
  if (!$arr) {
    unlink($file);
    error('Bad url.');
  }
  return image_type_to_extension($arr[2], false);
}