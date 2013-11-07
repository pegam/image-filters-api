<?php

class Utils {

  public static function delDirRecursive($dir) {
    $rdi = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
    $paths = new RecursiveIteratorIterator($rdi, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($paths as $path) {
      if ($path->isFile()) {
        unlink($path->getRealPath());
      } else {
        rmdir($path->getRealPath());
      }
    }
    rmdir($dir);
  }

}