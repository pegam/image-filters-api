<?php

$outfile = 'delete.out';
if (file_exists($outfile)) {
  unlink($outfile);
}

$t = time();
output('time: ' . date('c', $t) . ' (' . $t . ')' . "<br>\n");

$dir = dirname(__FILE__) . '/media/tmp';
$time_limit = $t - (1 * 60 * 60);
output('time-limit: ' . $time_limit . "<br>\n");

$count_limit = 2;
output('count-limit: ' . $count_limit . "<br>\n");

$tmp_img_dirs = array();
foreach (scandir($dir) as $file) {
  if ($file === '.' || $file === '..') {
    continue;
  }
  output($file);
  clearstatcache();
  $file = "{$dir}/{$file}";
  if (is_dir($file)) {
    foreach (scandir($file) as $img_file) {
      if ($img_file === '.' || $img_file === '..') {
        continue;
      }
      if (strpos($img_file, 'original-img.') === 0 || strpos($img_file, 'edited-img.') === 0) {
        $fctime = filectime("{$file}/{$img_file}");
        if ($fctime < $time_limit) {
          del_dir($file);
          output(' - <span style="color:red;">deleted (time-limit)</span>');
        } else {
          $tmp_img_dirs[$fctime] = $file;
          output(' - <span style="color:green;">under time-limit</span>');
        }
        break;
      }
    }
  } else {
    if (filectime("{$file}/{$img_file}") < $time_limit) {
      unlink($file);
      output(' - <span style="color:red;">deleted</span>');
    } else {
      output(' - <span style="color:green;">under time-limit</span>');
    }
  }
  output("<br>\n");
}

ksort($tmp_img_dirs);
print_r($tmp_img_dirs);
foreach (array_slice($tmp_img_dirs, 0, -$count_limit, true) as $tmp_dir) {
  del_dir($tmp_dir);
  output(basename($tmp_dir) . " - <span style=\"color:red;\">deleted (count-limit)</span><br>\n");
}


function del_dir($dir) {
  foreach (scandir($dir) as $file) {
    if ($file === '.' || $file === '..') {
      continue;
    }
    $file = "{$dir}/{$file}";
    if (is_dir($file)) {
      del_dir($file);
    } else {
      unlink($file);
    }
  }
  rmdir($dir);
}

function output($str) {
  global $outfile;
  file_put_contents($outfile, $str, FILE_APPEND);
  echo $str;
}