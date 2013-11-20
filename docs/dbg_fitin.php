<?php
$base_url = 'http://api.imagefilters.com';
$version = 'v1.0';
?><html>
  <head>
    <link href="css/dbg.css" rel="stylesheet" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/dbg.js"></script>
    <title>DBG FIT IN</title>
  </head>
  <body>
    <form id="fitin" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/fitin?" method="POST">
      FIT IN<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      New Horizontal Size:
      <input class="hsize" type="text" />
      <br />
      New Vertical Size:
      <input class="vsize" type="text" />
      <br />
      Resample:
      <input class="resample" type="checkbox" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
  </body>
</html>