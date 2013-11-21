<?php

if (file_exists('environment') && trim(file_get_contents('environment')) === 'production') {
  $base_url = 'http://api-imagefilters.byethost31.com';
} else {
  $base_url = 'http://api.imagefilters.com';
}

$version = 'v1.0';