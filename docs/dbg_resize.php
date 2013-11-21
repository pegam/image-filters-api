<?php
require 'dbg_url.php';
?><html>
  <head>
    <link href="css/dbg.css" rel="stylesheet" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/dbg.js"></script>
    <title>DBG RESIZE</title>
  </head>
  <body>
    <form id="resize" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/resize?" method="POST">
      RESIZE<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      New Horizontal Size:
      <input class="hsize" type="text" />
      (min: 1)
      <br />
      New Vertical Size:
      <input class="vsize" type="text" />
      (min: 1)
      <br />
      Resample:
      <input class="resample" type="checkbox" />
      <?php include 'dbg_output_formats.php' ;?>
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
  </body>
</html>