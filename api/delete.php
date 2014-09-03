<?php

$t = time();
echo 'time: ' . date('c', $t) . ' (' . $t . ')' . '<br>';

$dir = $_SERVER['DOCUMENT_ROOT'] . '/temporary';
$time_limit = $t - 3 * 60;
echo 'time-limit: ' . $time_limit . '<br>';

foreach (scandir($dir) as $file) {
  if ($file === '.' || $file === '..') {
    continue;
  }
  echo $file;
  clearstatcache();
  if (filectime($dir . '/' . $file) < $time_limit) {
    if (is_dir($dir . '/' . $file)) {
      del_dir($dir . '/' . $file);
    } else {
      unlink($dir . '/' . $file);
    }
    echo ' - <span style="color:red;">deleted</span>';
  } else {
    echo ' - <span style="color:green;">under time-limit</span>';
  }
  echo '<br>';
}


function del_dir($dir) {
  foreach (scandir($dir) as $file) {
    if ($file === '.' || $file === '..') {
      continue;
    }
    if (is_dir($dir . '/' . $file)) {
      del_dir($dir . '/' . $file);
    } else {
      unlink($dir . '/' . $file);
    }
  }
  rmdir($dir);
}