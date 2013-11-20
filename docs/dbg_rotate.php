<?php
$base_url = 'http://api.imagefilters.com';
//$base_url = 'http://api-imagefilters.byethost31.com';
$version = 'v1.0';
?><html>
  <head>
    <link href="css/dbg.css" rel="stylesheet" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/dbg.js"></script>
    <title>DBG ROTATE</title>
  </head>
  <body>
    <form id="rotate" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/rotate?" method="POST">
      ROTATE<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      Angle:
      <input class="angle" type="text" />
      (float)
      <br />
      Background - Red Component:
      <input class="bgred" type="text" />
      (0 - 255)
      <br />
      Background - Green Component:
      <input class="bggreen" type="text" />
      (0 - 255)
      <br />
      Background - Blue Component:
      <input class="bgblue" type="text" />
      (0 - 255)
      <br />
      Background - Alpha Component:
      <input class="bgalpha" type="text" />
      (0 - 127)
      <br />
      Resample:
      <input class="resample" type="checkbox" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
  </body>
</html>