<!DOCTYPE html>
<html>
  <head>
    <title>Image Editor</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/api-actions.css" />
    <link rel="stylesheet" type="text/css" href="css/tooltip.css" />
    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/api-actions.js"></script>
    <script src="js/hash.js"></script>
    <script src="js/tooltip.js"></script>
    <script src="js/submit.js"></script>
    <script>
      var apiDomain = '<?php echo $apiDomain; ?>';
    </script>
  </head>
  <body class="centered-text">
    <div id="container">
      <div id="top-outer" class="top">
        <div id="top-inner" class="top centered-text">
          <h1 id="title">Image Editor</h1>
        </div>
      </div>
      <div id="upload-container">
        <div class="cell">
          Upload Image:<br />
          <input type="radio" id="radio-upload-local" name="radio-upload" value="local" checked /><label for="radio-upload-local">Local File</label><br />
          <input type="radio" id="radio-upload-remote" name="radio-upload" value="remote" /><label for="radio-upload-remote">Remote File</label><br />
        </div>
        <div class="cell vertical-align">
          <div id="upload-local" class="upload">
            <input type="file" id="f_file_local" name="post_img" />
          </div>
          <div id="upload-remote" class="upload">
            <input type="text" id="f_file_remote" name="url" placeholder=" Url" size="100" />
          </div>
        </div>
        <br class="clear" />
      </div>
      <hr />
      <div id="actions-container" class="centered-text">
        <div id="loader-container">
          <img class="loader" src="media/images/ajax-loader.gif" />
        </div>
        <div id="api-actions"><ul></ul></div>
        <div id="api-actions-error" class="text-color-red">Error calling Image API!</div>
      </div>
      <hr />
      <div class="row">
        <div id="api-call-params" class="cell left-column">
          <button type="button" id="submit-btn" disabled>Edit Image</button>
          <div id="action-params"></div>
        </div>
        <div id="original-image" class="cell right-column">
          Original Image:
          <div id="img-original" class="img-container">
            <a target="_blank"><img id="img-original-local" src="" alt="Original image" class="img" /></a>
            <a target="_blank"><img id="img-original-remote" src="" alt="Original image" class="img" /></a>
          </div>
        </div>
        <br class="clear" />
      </div>
      <div class="row">
        <div id="api-response" class="cell left-column">
          Debug:
          <div id="debug">
            <div id="api-url"></div>
            <div id="api-code"></div>
            <div id="api-text"></div>
          </div>
        </div>
        <div id="edited-image" class="cell right-column">
          Edited Image:
          <div id="img-edited" class="img-container"></div>
        </div>
        <br class="clear" />
      </div>
    </div>
  </body>
</html>