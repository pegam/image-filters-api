<!DOCTYPE html>
<html>
  <head>
    <title>Image Editor</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
  </head>
  <body>
    <div id="container">
      <div id="top">
        <h1>Image Editor</h1>
      </div>
      <div id="upload-container">
        <div class="row">
          Upload Image:<br />
          <input type="radio" name="f_upload" value="local" checked>Local File<br>
          <input type="radio" name="f_upload" value="remote">Remote File<br>
        </div>
        <div class="row vertical-align">
          <div id="upload-local" class="upload">
            <input type="file" id="f_file_local" name="f_file_local" />
          </div>
          <div id="upload-remote" class="upload">
            <input type="text" id="f_file_remote" name="f_file_remote" placeholder=" Url" size="100" />
          </div>
        </div>
        <br class="clear" />
      </div>
      <hr />
      <div id="actions-container"></div>
      <hr />
      <div id="left" class="row">
        <button type="button" disabled>Edit</button>
        <div id="action-params"></div>
      </div>
      <div id="right" class="row">
        Original Image:
        <div id="img-original" class="img-container"></div>
        <p></p>
        Edited Image:
        <div id="img-edited" class="img-container"></div>
      </div>
      <br class="clear" />
    </div>
  </body>
</html>