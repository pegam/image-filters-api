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
      <div id="api-version">Api version: <span id="version"></span></div>
      <br class="clear" />
      <div id="upload-container">
        <div class="cell">
          Upload Image:<br />
          <input type="radio" id="radio-upload-local" name="radio-upload" value="local" checked /><label for="radio-upload-local">Local File</label><br />
          <input type="radio" id="radio-upload-remote" name="radio-upload" value="remote" /><label for="radio-upload-remote">Remote File</label><br />
          <span class="small-text">(Supported formats: </span><span id="supported-formats"></span><span class="small-text">)</span><br />
        </div>
        <div class="cell vertical-align">
          <div id="upload-local" class="upload no-display">
            <input type="file" id="file_local" name="t_post_img" />
            <input type="hidden" id="f_file_local" name="url" />
          </div>
          <div id="upload-remote" class="upload no-display">
            <input type="text" id="file_remote" name="t_url" placeholder=" Url" size="85" />
            <input type="hidden" id="f_file_remote" name="url" />
          </div>
        </div>
        <br class="clear" />
      </div>
      <hr />
      <div id="actions-container" class="centered-text">
        <div id="loader-container">
          <img class="loader" src="media/images/ajax-loader.gif" />
        </div>
        <div id="api-actions" class="no-display"><ul></ul></div>
        <div id="api-actions-error" class="api-error no-display text-color-red">Error!</div>
      </div>
      <hr />
      <div class="row">
        <div id="api-call-params" class="cell left-column">
          <button type="button" id="submit-btn" disabled>Edit Image</button>
          <div id="action-params"></div>
        </div>
        <div id="original-image" class="cell right-column">
          Original Image:
          <div class="save-img no-display"><a href="javascript:void(0)" download>Save image</a></div>
          <br class="clear" />
          <div id="img-original" class="img-container">
            <div id="local-image-container" class="img no-display">
              <a target="_blank"><img id="img-original-local" src="" alt="Original image" class="img no-display" /></a>
              <div id="api-original-local-img-error" class="api-error no-display"></div>
            </div>
            <div id="remote-image-container" class="img no-display">
              <a target="_blank"><img id="img-original-remote" src="" alt="Original image" class="img no-display" /></a>
              <div id="api-original-remote-img-error" class="api-error no-display"></div>
            </div>
          </div>
        </div>
        <br class="clear" />
      </div>
      <div class="row">
        <div class="cell left-column"></div>
        <div id="edited-image" class="cell right-column">
          Edited Image:
          <div class="save-img no-display"><a href="javascript:void(0)" download>Save image</a></div>
          <br class="clear" />
          <div id="img-edited" class="img-container">
            <a target="_blank"><img id="imgage-edited" src="" alt="Original image" class="img no-display" /></a>
            <div id="api-edited-img-error" class="api-error no-display text-color-red">Error!</div>
          </div>
        </div>
        <br class="clear" />
      </div>
    </div>
  </body>
</html>