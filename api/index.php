<?php

header("HTTP/1.1 500 Internal Server Error");

ob_start();
require_once dirname(__FILE__) . '/protected/classes/Api.php';

define('BASE_PATH', dirname(__FILE__));
$config = BASE_PATH . '/protected/config/apiConfig.php';

Api::createApplication($config);
Api::app()->setTimezone('Europe/Berlin');
Api::app()->run();
if (ob_get_length()) {
  ob_end_flush();
}