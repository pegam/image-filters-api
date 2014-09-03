$(function() {
  $('#submit-btn').on('click', function() {
    $('#edited-image > div.save-img > a').parent().addClass('no-display');
    $('#upload-container > div.cell:first-child').removeAttr('style');
    if (!$('div.upload:visible > input').val()) {
      $('#upload-container > div.cell:first-child').css('border', 'solid red 1px');
    } else {
      var action = $.trim($('li.action-active > a').text()),
          paramsObj = apiResourcesObj[resource]['actions'][action]['parameters'],
          params = checkParams(paramsObj, action);
      if (!$.isEmptyObject(params)) {
        params['api_action'] = action;
        sendToApi(params);
      }
    }
  });
});

function checkParams(paramsObj, action) {
  var ret = {};
  $('[id^=f_]').each(function() {
    $(this).removeAttr('style');
    var k = $(this).attr('name'),
        v = $(this).val();
    if (k !== 'post_img') {
      if (!paramsObj || !paramsObj[k]) {
        if (action === 'filter') {
          var filterAction = $('#f_name').val(),
              filterParamsObj = paramsObj['name']['choice'][filterAction]['parameters'],
              filterParams = checkFilterParams(filterParamsObj);
          if (!$.isEmptyObject(filterParams)) {
            for (var i in filterParams) {
              ret[i] = filterParams[i];
            }
          } else {
            ret = {};
          }
          return true;
        } else {
          alert('error');
          ret = {};
          return false;
        }
      }
      if ((paramsObj[k]['required'] && (!v && v !== 0)) || !isOkType(paramsObj[k], v)) {
        $(this).css('border', 'solid red 1px');
        ret = {};
        return false;
      }
      if (v || v === 0) {
        if (k === 'url') {
          if (!window.location.origin) {
            window.location.origin = window.location.protocol+"//"+window.location.host;
          }
          if ($('#radio-upload-remote').is(':checked') && $(this).attr('id') === 'f_file_remote') {
            ret[k] = encodeURIComponent(window.location.origin + v);
          }
          if ($('#radio-upload-local').is(':checked') && $(this).attr('id') === 'f_file_local') {
            ret[k] = encodeURIComponent(window.location.origin + v);
          }
        } else {
          ret[k] = v;
        }
      }
    }
    return true;
  });
  return ret;
}

function checkFilterParams(paramsObj) {
  var ret = {};
  $('#filter-params > [id^=f_]').each(function() {
    $(this).removeAttr('style');
    var k = $(this).attr('name'),
        v = $(this).val();
    if (!paramsObj || !paramsObj[k]) {
      alert('error');
      ret = {};
      return false;
    }
    if ((paramsObj[k]['required'] && (!v && v !== 0)) || !isOkType(paramsObj[k], v)) {
      $(this).css('border', 'solid red 1px');
      ret = {};
      return false;
    }
    if (v || v === 0) {
      ret[k] = v;
    }
  });
  return ret;
}

function isOkType(obj, value) {
  var ret = true;
  if (obj['type'] === 'integer' || obj['type'] === 'float') {
    var t = Math.floor(value);
    if (!$.isNumeric(value) || (obj['type'] === 'integer' && t != value)) {
      ret = false;
    }
    value = t;
  }
  return ret;
}

function sendToApi(params) {
  var url = 'getEditedImage.php';
  $('#imgage-edited').attr('src', 'media/images/ajax-loader.gif');
  ajaxGet(url, params, sendToApiSuccess, sendToApiError);
}

function sendToApiSuccess(response, textStatus, jqXHR) {
  if (response['src']) {
    $('#api-edited-img-error').addClass('no-display');
    $('#imgage-edited').attr('src', response['src']).removeClass('no-display').parent().attr('href', response['src']);
    $('#edited-image > div.save-img > a').attr('href', response['src']).parent().removeClass('no-display');
  } else {
    sendToApiError(jqXHR);
  }
}

function sendToApiError(jqXHR) {
  $('#imgage-edited').addClass('no-display');
  $('#api-edited-img-error').removeClass('no-display');
  if (debug) {
    $('#api-edited-img-error').html('<span class="text-color-red">Error!</span><br />code: ' + jqXHR.status + '<br />response: ' + jqXHR.responseText + '<br />');
  } else {
    $('#api-edited-img-error').html('<span class="text-color-red">Error!</span>');
  }
}