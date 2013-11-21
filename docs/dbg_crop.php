<?php
require 'dbg_url.php';
?><html>
  <head>
    <link href="css/dbg.css" rel="stylesheet" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/dbg.js"></script>
    <title>DBG CROP</title>
  </head>
  <body>
    <form id="crop" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/crop?" method="POST">
      CROP<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      X Point:
      <input class="xpoint" type="text" />
      (min: 0)
      <br />
      Y Point:
      <input class="ypoint" type="text" />
      (min: 0)
      <br />
      (The coordinates refer to the upper left corner.)
      <br />
      New Horizontal Size:
      <input class="hsize" type="text" />
      (min: 1)
      <br />
      New Vertical Size:
      <input class="vsize" type="text" />
      (min: 1)
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
  </body>
</html>