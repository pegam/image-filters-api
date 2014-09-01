$(function() {
  changeRadio();
  $('input:radio[name=radio-upload]').on('change', function() {
    changeRadio();
  });
  loadApiAction();
  $('#f_file_remote').on('blur', function() {
    $('#img-original-remote').attr('src', $(this).val());
    $('#img-original-remote').css('display', 'inline');
    $('#img-original-remote').parent().attr('href', $(this).val());
  });
  $('#f_file_local').on('change', function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      var dataStr = reader.result;
      $('#img-original-local').attr('src', dataStr);
      $('#img-original-local').css('display', 'inline');
      $('#img-original-local').parent().attr('href', dataStr);
    }
    reader.readAsDataURL(this.files[0]);
  });
  if (!debug) {
    $('#api-response').css('visibility', 'hidden');
  }
});

var clientId = '53ecca8609d14',
    apiKey = 'ddc366b21106b13347e9cba8e63056370735072e',
    apiResourcesObj = {},
    resource = 'images',
    secureApi = true,
    debug = false;

function changeRadio() {
  $('input:radio[name=radio-upload]').each(function() {
    if ($(this).is(':checked')) {
      $('div#upload-' + $(this).val()).css('display', 'block');
      if ($('#img-original-' + $(this).val()).attr('src')) {
        $('#img-original-' + $(this).val()).css('display', 'inline');
      }
    } else {
      $('div#upload-' + $(this).val()).css('display', 'none');
      $('#img-original-' + $(this).val()).css('display', 'none');
    }
  });
  $('#img-edited').empty();
}

function buildUrl(controller, data) {
  var url = apiDomain,
      query = '';
  if (data) {
    for (var i in data) {
      if (query) {
        query += '&';
      }
      query += i + '=' + data[i];
    }
  }
  if (secureApi) {
    var p = controller;
    if (query) {
      query += '&';
    }
    query += 'client=' + clientId;
    p += '?' + query;
    url += '/' + getSignature(p) + '/' + p
  } else {
    url += '/controller';
    if (query) {
      url += '?' + query;
    }
  }
  return url;
}

function getSignature(p) {
  var shaObj = new jsSHA(p, "TEXT");
  var hmac = shaObj.getHMAC(apiKey, "TEXT", "SHA-1", "B64");
  return hmac.replace(/\+/g, '-').replace(/\//g, '_');
}

function loadApiAction() {
  var url = buildUrl(resource);
  jQueryAjaxGet(url, 'GET', showActionsSuccess, showActionsError);
}

function showActionsSuccess(data) {
  if (!data[resource] || !data[resource]['actions']) {
    showActionsError();
  } else {
    apiResourcesObj = data;
    for (var action in data[resource]['actions']) {
      if (action === 'types') {
        continue;
      }
      var description = '';
      if (data[resource]['actions'][action]['description']) {
        description = data[resource]['actions'][action]['description'];
      }
      createActionButton(action, description);
      $('#api-actions-error').css('display', 'none');
      $('#loader-container').css('display', 'none');
      $('#api-actions').css('display', 'block');
    }
  }
}

function showActionsError() {
  $('#api-actions-error').css('display', 'block');
  $('#loader-container').css('display', 'none');
  $('#api-actions').css('display', 'none');
}

function printApiResponse(url, responseCode, responseText) {
  $('#api-url').html('<a href="javascript:void(0)" onclick="toggleDbgApiDiv(\'api-request-url\')">url</a><div id="api-request-url" class="api-dbg"><pre>' + url + '</pre></div>');
  $('#api-code').html('code: <span class="text-color-red">' + responseCode + '</span>');
  $('#api-text').empty();
  if (responseText) {
    $('#api-text').html('<a href="javascript:void(0)" onclick="toggleDbgApiDiv(\'api-response-text\')">data</a><div id="api-response-text" class="api-dbg"><pre>' + responseText + '</pre></div>');
  }
}

function toggleDbgApiDiv(id) {
  var d = $('#' + id);
  if (d.length) {
    if (d.css('display') === 'block') {
      d.css('display', 'none');
    } else {
      d.css('display', 'block');
    }
  }
}

function createActionButton(action, description) {
  var a = '<li><a href="javascript:void(0)"';
  if (description) {
    a += ' data-tooltip="' + description + '" class="tooltip" onmouseover="hoverOverTooltip(this, event)" onmouseout="hoverOutTooltip(this)"';
  }
  a += ' onclick="apiAction(this)">' + action + '</a></li>';
  $('div#api-actions > ul').append(a);
}

function capitaliseFirstLetter(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function jQueryAjaxGet(url, method, success, error) {
  var settings = {
    url: url,
    type: method,
    cache: true,
    crossDomain: true,
    dataType: 'json',
    processData: true,
    success: success,
    error: error,
    complete: function(jqXHR) {
      var responseCode = jqXHR.status,
          responseText;
      if (method === 'GET') {
        responseText = jqXHR.responseText;
      }
      printApiResponse(url, responseCode, $.trim(responseText));
    }
  };
  if (success) {
    settings['success'] = success;
  }
  if (error) {
    settings['error'] = error;
  }
  $.ajax(settings);
}