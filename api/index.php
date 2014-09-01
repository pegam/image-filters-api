<?php

header("HTTP/1.1 500 Internal Server Error");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: origin, x-csrftoken, content-type, accept');

date_default_timezone_set('Europe/Berlin');

ob_start();
define('BASE_PATH', dirname(__FILE__));
require_once BASE_PATH . '/protected/classes/Api.php';
$config = BASE_PATH . '/protected/config/apiConfig.php';

try {
  Api::createApplication($config);
  Api::app()->run();
  if (ob_get_length()) {
    ob_end_flush();
  }
} catch (Exception $e) {
  if (Api::app() && Api::app()->debug) {
    echo nl2br($e->getMessage()) . "\n<br>\n";
    echo nl2br($e->getFile()) . "\n<br>\n";
    echo nl2br($e->getLine()) . "\n<br>\n";
    echo nl2br($e->getTraceAsString()) . "\n<br>\n";
  }
  throw $e;
}
