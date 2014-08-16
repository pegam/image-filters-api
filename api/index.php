<?php

header("HTTP/1.1 500 Internal Server Error");

date_default_timezone_set('Europe/Berlin');

ob_start();
require_once dirname(__FILE__) . '/protected/classes/Api.php';

define('BASE_PATH', dirname(__FILE__));
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
