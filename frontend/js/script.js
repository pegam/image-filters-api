var debug = true,
    remote_img_url = '',
    local_img_url = '';


$(function() {
  changeRadio();
  $('input:radio[name=radio-upload]').on('change', function() {
    changeRadio();
  });
  loadApiActions();
  $('#f_file_remote').on('blur', function() {
    var url = $(this).val();
    if (url !== $('#f_file_remote').data('url')) {
      $('#original-image > div.save-img').css('display', 'none');
      if (url) {
        $('#img-original-remote').attr('src', 'media/images/ajax-loader.gif').parent().attr('href', 'javascript:void(0)');
        uploadRemoteImg(url);
      }
    }
  });
  $('#f_file_local').on('change', function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      var dataStr = reader.result;
      $('#img-original-local').attr('src', dataStr).css('display', 'inline').parent().attr('href', dataStr);
    };
    reader.readAsDataURL(this.files[0]);
  });
});

//var clientId = '53ecca8609d14',
//    apiKey = 'ddc366b21106b13347e9cba8e63056370735072e',
//    apiResourcesObj = {},
//    resource = 'images',
//    secureApi = false,
//    debug = true;

function changeRadio() {
  $('input:radio[name=radio-upload]').each(function() {
    var v = $(this).val();
    if ($(this).is(':checked')) {
      $('div#upload-' + v).css('display', 'block');
      if ($('#img-original-' + v).attr('src')) {
        if (!$('#api-original-' + v + '-img-error').is(':visible')) {
          $('#img-original-' + v).css('display', 'inline');
        }
      }
    } else {
      $('div#upload-' + v).css('display', 'none');
      $('#img-original-' + v).css('display', 'none');
      $('#api-original-' + v + '-img-error').css('display', 'none');
    }
  });
  $('#img-edited').empty();
}

function loadApiActions() {

}

function uploadRemoteImg(imgUrl) {
  var url = 'uploadOriginalImage.php',
      data = {
        'url': imgUrl
      };
  $('#f_file_remote').data('url', imgUrl);
  return ajaxGet(url, data, uploadRemoteImgSuccess, uploadRemoteImgError);
}

function uploadRemoteImgSuccess(response, textStatus, jqXHR) {
  if (response['src']) {
    $('#api-original-remote-img-error').css('display', 'none');
    $('#img-original-remote').attr('src', response['src']).css('display', 'inline').parent().attr('href', response['src']);
    $('#original-image > div.save-img > a').attr('href', response['src']).parent().css('display', 'block');
  } else {
    uploadRemoteImgError(jqXHR);
  }
}

function uploadRemoteImgError(jqXHR) {
  $('#img-original-remote').css('display', 'none');
  $('#api-original-remote-img-error').css('display', 'block');
  if (debug) {
    $('#api-original-remote-img-error').html('<span class="text-color-red">Error!</span><br />code: ' + jqXHR.status + '<br />response: ' + jqXHR.responseText + '<br />');
  }
  $('#f_file_remote').removeData('url');
}

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
//      $('#api-actions-error').css('display', 'none');
//      $('#loader-container').css('display', 'none');
//      $('#api-actions').css('display', 'block');
//    }
//  }
//}
//
//function showActionsError() {
//  $('#api-actions-error').css('display', 'block');
//  $('#loader-container').css('display', 'none');
//  $('#api-actions').css('display', 'none');
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
//  $('div#api-actions > ul').append(a);
//}

//function toggleDbgApiDiv(id) {
//  var d = $('#' + id);
//  if (d.length) {
//    if (d.css('display') === 'block') {
//      d.css('display', 'none');
//    } else {
//      d.css('display', 'block');
//    }
//  }
//}

function capitaliseFirstLetter(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

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

function ajaxGet(url, data, success, error) {
  var settings = {
    url: url,
    cache: false,
    dataType: 'json',
    error: error,
    success: success
  };
  if (!$.isEmptyObject(data)) {
    settings['data'] = data;
  }
  $.ajax(settings);
}