var debug = false,
    apiResourcesObj = {},
    resource = 'images',
    remote_img_url = '',
    local_img_url = '';


$(function() {
  changeRadio();
  $('input:radio[name=radio-upload]').on('change', function() {
    changeRadio();
  });
  loadSupportedFormats();
  loadApiActions();
  $('#file_remote').on('blur', function() {
    var url = $(this).val();
    $('#imgage-edited').addClass('no-display');
    $('#edited-image > div.save-img > a').parent().addClass('no-display');
    $('#f_file_remote').val('');
    if (url !== $('#file_remote').data('url')) {
      $('#original-image > div.save-img').addClass('no-display');
      if (url) {
        $('#img-original-remote').attr('src', 'media/images/ajax-loader.gif').removeClass('no-display').parent().attr('href', 'javascript:void(0)');
        $('#remote-image-container').removeClass('no-display');
        uploadRemoteImg(url);
      } else {
        $('#img-original-remote').attr('src', '').addClass('no-display').parent().removeAttr('href');
        $('#remote-image-container').removeClass('no-display');
        $('#file_remote').removeData('url');
      }
    }
  });
  $('#file_local').on('change', function() {
    $('#imgage-edited').addClass('no-display');
    $('#edited-image > div.save-img > a').parent().addClass('no-display');
    $('#f_file_local').val();
    $('#original-image > div.save-img').addClass('no-display');
    $('#img-original-local').attr('src', 'media/images/ajax-loader.gif').removeClass('no-display').parent().attr('href', 'javascript:void(0)');
    $('#local-image-container').removeClass('no-display');
    uploadLocalImg();
  });
});

function changeRadio() {
  $('input:radio[name=radio-upload]').each(function() {
    var v = $(this).val();
    if ($(this).is(':checked')) {
      $('#upload-' + v).removeClass('no-display');
      $('#' + v + '-image-container').removeClass('no-display');
    } else {
      $('#upload-' + v).addClass('no-display');
      $('#' + v + '-image-container').addClass('no-display');
    }
  });
  $('#imgage-edited').addClass('no-display');
  $('#edited-image > div.save-img > a').parent().addClass('no-display');
}

function loadSupportedFormats() {
  var url = 'getSupportedFormats.php';
  return ajaxGet(url, null, loadSupportedFormatsSuccess, loadSupportedFormatsError);
}

function loadSupportedFormatsSuccess(response, textStatus, jqXHR) {
  if ($.isArray(response)) {
    var formats = '';
    for (var i = 0; i < response.length; ++i) {
      if (formats) {
        if (i === response.length - 1) {
          formats += ' and ';
        } else {
          formats += ', ';
        }
      }
      formats += response[i];
    }
    $('#supported-formats').removeClass('text-color-red').addClass('small-text').html(formats);
  } else {
    loadSupportedFormatsError(jqXHR);
  }
}

function loadSupportedFormatsError(jqXHR) {
  $('#supported-formats').addClass('text-color-red').removeClass('small-text').html('Error.');
}

function loadApiActions() {
  var url = 'getActions.php';
  return ajaxGet(url, null, loadApiActionsSuccess, loadApiActionsError);
}

function loadApiActionsSuccess(response, textStatus, jqXHR) {
  if (response['version']) {
    $('#version').removeClass('text-color-red').html(response['version']);
  } else {
    $('#version').addClass('text-color-red').html('Error.');
  }
  if (response[resource] && response[resource]['actions']) {
    apiResourcesObj = response;
    for (var action in response[resource]['actions']) {
      if (action === 'types') {
        continue;
      }
      var description = '';
      if (response[resource]['actions'][action]['description']) {
        description = response[resource]['actions'][action]['description'];
      }
      createActionButton(action, description);
      $('#api-actions-error').addClass('no-display');
      $('#loader-container').addClass('no-display');
      $('#api-actions').removeClass('no-display');
    }
  } else {
    loadApiActionsError(jqXHR);
  }
}

function loadApiActionsError(jqXHR) {
  $('#api-actions-error').removeClass('no-display');
  $('#loader-container').addClass('no-display');
  $('#api-actions').addClass('no-display');
  if (debug) {
    alert(jqXHR.responseText);
  }
}

function uploadLocalImg() {
  var url = 'uploadOriginalImage.php',
      fd = new FormData();
  fd.append('userfile', $('#file_local')[0].files[0]);
  ajaxPost(url, fd, uploadLocalImgSuccess, uploadLocalImgError);
}

function uploadLocalImgSuccess(response, textStatus, jqXHR) {
  response = JSON.parse(response);
  if (response['src']) {
    $('#api-original-local-img-error').addClass('no-display');
    $('#img-original-local').attr('src', response['src']).removeClass('no-display').parent().attr('href', response['src']);
    $('#original-image > div.save-img > a').attr('href', response['src']).parent().removeClass('no-display');
    $('#f_file_local').val(response['src']);
  } else {
    uploadRemoteImgError(jqXHR);
  }
}

function uploadLocalImgError(jqXHR) {
  $('#img-original-local').addClass('no-display');
  $('#api-original-local-img-error').removeClass('no-display');
  if (debug) {
    $('#api-original-local-img-error').html('<span class="text-color-red">Error!</span><br />code: ' + jqXHR.status + '<br />response: ' + jqXHR.responseText + '<br />');
  } else {
    $('#api-original-local-img-error').html('<span class="text-color-red">Error!</span>');
  }
}

function uploadRemoteImg(imgUrl) {
  var url = 'uploadOriginalImage.php',
      data = {
        'url': imgUrl
      };
  $('#file_remote').data('url', imgUrl);
  return ajaxGet(url, data, uploadRemoteImgSuccess, uploadRemoteImgError);
}

function uploadRemoteImgSuccess(response, textStatus, jqXHR) {
  if (response['src']) {
    $('#api-original-remote-img-error').addClass('no-display');
    $('#img-original-remote').attr('src', response['src']).removeClass('no-display').parent().attr('href', response['src']);
    $('#original-image > div.save-img > a').attr('href', response['src']).parent().removeClass('no-display');
    $('#f_file_remote').val(response['src']);
  } else {
    uploadRemoteImgError(jqXHR);
  }
}

function uploadRemoteImgError(jqXHR) {
  $('#img-original-remote').addClass('no-display');
  $('#api-original-remote-img-error').removeClass('no-display');
  if (debug) {
    $('#api-original-remote-img-error').html('<span class="text-color-red">Error!</span><br />code: ' + jqXHR.status + '<br />response: ' + jqXHR.responseText + '<br />');
  } else {
    $('#api-original-remote-img-error').html('<span class="text-color-red">Error!</span>');
  }
  $('#file_remote').removeData('url');
}

function capitaliseFirstLetter(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function ajaxGet(url, data, success, error) {
  var settings = {
    url: url,
    dataType: 'json',
    error: error,
    success: success
  };
  if (!$.isEmptyObject(data)) {
    settings['data'] = data;
  }
  $.ajax(settings);
}

function ajaxPost(url, data, success, error) {
  var settings = {
    url: url,
    contentType: false,
    processData: false,
    type: 'POST',
    error: error,
    success: success
  };
  if (!$.isEmptyObject(data)) {
    settings['data'] = data;
  }
  $.ajax(settings);
}