<?php

$apiDomain = 'http://api.imagefilters.com';
$envFile = $_SERVER['DOCUMENT_ROOT'] . '/protected/environment';
if (file_exists($envFile) && trim(file_get_contents($envFile)) === 'production') {
  $apiDomain = 'http://api-imagefilters.byethost31.com';
}