<?php

$apiDomain = 'http://api.imagefilters.com';
$envFile = dirname(__FILE__) . '/environment';
if (file_exists($envFile) && trim(file_get_contents($envFile)) === 'production') {
  $apiDomain = 'http://api-imagefilters.byethost31.com';
}