<?php

include 'protected/apiDomain.php';
include 'init.php';

$url = buildUrl($apiDomain, $secure);
$response = apiCurl($url);
success($response);

function buildUrl($apiDomain, $secure) {
  $url = $apiDomain;
  $path = 'images/types';
  if ($secure) {
    $url .= '/' . signature($path);
  }
  return "{$url}/{$path}";
}