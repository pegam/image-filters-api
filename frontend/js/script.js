var debug = true,
    apiResourcesObj = {},
    resource = 'images',
    remote_img_url = '',
    local_img_url = '';


$(function() {
  changeRadio();
  $('input:radio[name=radio-upload]').on('change', function() {
    changeRadio();
  });
  loadApiActions();
  $('#file_remote').on('blur', function() {
    var url = $(this).val();
    $('#imgage-edited').addClass('no-display');
    $('#edited-image > div.save-img > a').parent().addClass('no-display');
    $('#f_file_remote').val('');
    if (url !== $('#file_remote').data('url')) {
      $('#original-image > div.save-img').addClass('no-display');
      if (url) {
        $('#img-original-remote').attr('src', 'media/images/ajax-loader.gif').parent().attr('href', 'javascript:void(0)');
        $('#remote-image-container').removeClass('no-display');
        uploadRemoteImg(url);
      }
    }
  });
  $('#file_local').on('change', function() {
    $('#imgage-edited').addClass('no-display');
    $('#edited-image > div.save-img > a').parent().addClass('no-display');
    $('#f_file_local').val();
    $('#original-image > div.save-img').addClass('no-display');
    $('#img-original-local').attr('src', 'media/images/ajax-loader.gif').parent().attr('href', 'javascript:void(0)');
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

function loadApiActions() {
  var url = 'getActions.php';
  return ajaxGet(url, null, loadApiActionsSuccess, loadApiActionsError);
}

function loadApiActionsSuccess(response, textStatus, jqXHR) {
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

//var clientId = '53ecca8609d14',
//    apiKey = 'ddc366b21106b13347e9cba8e63056370735072e',
//    apiResourcesObj = {},
//    resource = 'images',
//    secureApi = false,
//    debug = true;

//function buildUrl(controller, data) {
//  var url = apiDomain,
//      query = '';
//  if (data) {
//    for (var i in data) {
//      if (query) {
//        query += '&';
//      }
//      query += i + '=' + data[i];
//    }
//  }
//  if (secureApi) {
//    var p = controller;
//    if (query) {
//      query += '&';
//    }
//    query += 'client=' + clientId;
//    p += '?' + query;
//    url += '/' + getSignature(p) + '/' + p;
//  } else {
//    url += '/' + controller;
//    if (query) {
//      url += '?' + query;
//    }
//  }
//  return url;
//}

//function getSignature(p) {
//  var shaObj = new jsSHA(p, "TEXT");
//  var hmac = shaObj.getHMAC(apiKey, "TEXT", "SHA-1", "B64");
//  return hmac.replace(/\+/g, '-').replace(/\//g, '_');
//}

//function loadApiAction() {
//  var url = buildUrl(resource);
//  jQueryAjaxGet(url, 'GET', showActionsSuccess, showActionsError);
//}

//function showActionsSuccess(data) {
//  if (!data[resource] || !data[resource]['actions']) {
//    showActionsError();
//  } else {
//    apiResourcesObj = data;
//    for (var action in data[resource]['actions']) {
//      if (action === 'types') {
//        continue;
//      }
//      var description = '';
//      if (data[resource]['actions'][action]['description']) {
//        description = data[resource]['actions'][action]['description'];
//      }
//      createActionButton(action, description);
//      $('#api-actions-error').addClass('no-display');
//      $('#loader-container').addClass('no-display');
//      $('#api-actions').removeClass('no-display');
//    }
//  }
//}
//
//function showActionsError() {
//  $('#api-actions-error').removeClass('no-display');
//  $('#loader-container').addClass('no-display');
//  $('#api-actions').addClass('no-display');
//}
//
//function printApiResponse(url, responseCode, responseText) {
//  $('#api-url').html('<a href="javascript:void(0)" onclick="toggleDbgApiDiv(\'api-request-url\')">url</a><div id="api-request-url" class="api-dbg"><pre>' + url + '</pre></div>');
//  $('#api-code').html('code: <span class="text-color-red">' + responseCode + '</span>');
//  $('#api-text').empty();
//  if (responseText) {
//    $('#api-text').html('<a href="javascript:void(0)" onclick="toggleDbgApiDiv(\'api-response-text\')">data</a><div id="api-response-text" class="api-dbg"><pre>' + responseText + '</pre></div>');
//  }
//}

//function createActionButton(action, description) {
//  var a = '<li><a href="javascript:void(0)"';
//  if (description) {
//    a += ' data-tooltip="' + description + '" class="tooltip" onmouseover="hoverOverTooltip(this, event)" onmouseout="hoverOutTooltip(this)"';
//  }
//  a += ' onclick="apiAction(this)">' + action + '</a></li>';
//  $('#api-actions > ul').append(a);
//}

//function toggleDbgApiDiv(id) {
//  var d = $('#' + id);
//  if (d.length) {
//    if (!d.hasClass('no-display')) {
//      d.addClass('no-display');
//    } else {
//      d.removeClass('no-display');
//    }
//  }
//}

//function jQueryAjaxGet(url, method, success, error) {
//  var settings = {
//    url: url,
//    type: method,
//    cache: true,
//    crossDomain: true,
//    dataType: 'json',
//    processData: true,
//    success: success,
//    error: error,
//    complete: function(jqXHR) {
//      var responseCode = jqXHR.status,
//          responseText;
//      if (method === 'GET') {
//        responseText = jqXHR.responseText;
//      }
//      printApiResponse(url, responseCode, $.trim(responseText));
//    }
//  };
//  if (success) {
//    settings['success'] = success;
//  }
//  if (error) {
//    settings['error'] = error;
//  }
//  $.ajax(settings);
//}