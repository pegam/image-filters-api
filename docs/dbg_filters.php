<?php
$base_url = 'http://api.imagefilters.com';
//$base_url = 'http://api-imagefilters.byethost31.com';
$version = 'v1.0';
?><html>
  <head>
    <link href="css/dbg.css" rel="stylesheet" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/dbg.js"></script>
    <title>DBG FILTERS</title>
  </head>
  <body>
    <select id="select_filter">
      <option value="negate" selected>Negate</option>
      <option value="grayscale">Grayscale</option>
      <option value="brightness">Brightness</option>
      <option value="contrast">Contrast</option>
      <option value="colorize">Colorize</option>
      <option value="edgedetect">Edge detect</option>
      <option value="emboss">Emboss</option>
      <option value="gaussianblur">Gaussian blur</option>
      <option value="selectiveblur">Selective blur</option>
      <option value="meanremoval">Mean removal</option>
      <option value="smooth">Smooth</option>
      <option value="pixelate">Pixelate</option>
    </select>
    <br /><br /><br />
    <form id="if_negate" class="show" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=negate" method="POST">
      NEGATE<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_grayscale" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=grayscale&out=png" method="POST">
      GRAYSCALE<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_brightness" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=brightness&out=gif" method="POST">
      BRIGHTNESS<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      Level:
      <input class="level" type="text" />
      (min: -255, max: 255)
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_contrast" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=contrast&out=jpeg" method="POST">
      CONTRAST<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      Level:
      <input class="level" type="text" />
      (min: 100, max: -100)
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_colorize" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=colorize" method="POST">
      COLORIZE<br /><br />
      Send this file: <input name="userfile" type="file" />
      <table>
        <tr>
          <td>Red:</td>
          <td><input class="red" type="text" /></td>
          <td>(min: -255, max: 255)</td>
        </tr>
        <tr>
          <td>Green:</td>
          <td><input class="green" type="text" /></td>
          <td>(min: -255, max: 255)</td>
        </tr>
        <tr>
          <td>Blue:</td>
          <td><input class="blue" type="text" /></td>
          <td>(min: -255, max: 255)</td>
        </tr>
        <tr>
          <td>Alpha:</td>
          <td><input class="alpha" type="text" /></td>
          <td>(min: 0, max: 127)</td>
        </tr>
      </table>
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_edgedetect" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=edgedetect&out=png" method="POST">
      EDGE DETECT<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_emboss" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=emboss&out=gif" method="POST">
      EMBOSS<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_gaussianblur" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=gaussianblur&out=jpg" method="POST">
      GAUSSIAN BLUR<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_selectiveblur" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=selectiveblur" method="POST">
      SELECTIVE BLUR<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_meanremoval" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=meanremoval&out=png" method="POST">
      MEAN REMOVAL<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_smooth" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=smooth&out=gif" method="POST">
      SMOOTH<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      Level:
      <input class="level" type="text" />
      (any float is accepted, large value = no change (recommended range: -10 ... 10))
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
    <form id="if_pixelate" class="hide" enctype="multipart/form-data" action="<?php echo $base_url; ?>/<?php echo $version; ?>/images/filter?name=pixelate&out=jpeg" method="POST">
      PIXELATE<br /><br />
      Send this file: <input name="userfile" type="file" />
      <br />
      Size:
      <input class="size" type="text" />
      (min: 1)
      <br />
      <input type="button" class="submit" value="Send File" />
    </form>
  </body>
</html>