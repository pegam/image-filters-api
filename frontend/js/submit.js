$(function() {
  $('#submit-btn').on('click', function() {
    $('#upload-container > div.cell:first-child').removeAttr('style');
    if (!$('div.upload:visible > input').val()) {
      $('#upload-container > div.cell:first-child').css('border', 'solid red 1px');
    } else {
      var action = $.trim($('li.action-active > a').text()),
          paramsObj = apiResourcesObj[resource]['actions'][action]['parameters'],
          params = checkParams(paramsObj, action);
      if (!$.isEmptyObject(params)) {
        sendToApi(action, params);
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
          if ($('#radio-upload-remote').is(':checked')) {
            ret[k] = encodeURIComponent(v);
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
  $('div#filter-params > [id^=f_]').each(function() {
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

function sendToApi(action, params) {
  $('#img-edited').html('<img class="loader" src="media/images/ajax-loader.gif" />');
  var url = buildUrl(resource + '/' + action, params);
  customAjaxGetImage(url, showImageSuccess, showImageError);
}

function showImageSuccess(imgSrc) {
  $('#img-edited').html('<img id="resulting-img" src="' + imgSrc + '" alt="Edited image" class="img" />');
}

function showImageError() {
  $('#img-edited').html('<span class="text-color-red">Error</span>');
}

function customAjaxGetImage(url, success, error) {
  var oReq = new XMLHttpRequest(),
      fd;
  oReq.addEventListener("error", error, false);
  oReq.open('POST', url, true);
  oReq.responseType = 'blob';
  oReq.onload = function() {
    var responseText;
    if (this.status !== 200) {
      showImageError();
      responseText = this.statusText;
    } else {
      var blob = oReq.response;
      var imgSrc = (window.webkitURL || window.URL).createObjectURL(blob);
      var reader  = new FileReader();
      reader.onloadend = function() {
        var aHref = reader.result;
        var checkExist = setInterval(function() {
          if ($('#resulting-img').length) {
            $('#resulting-img').wrap('<a href="' + aHref + '" target="_blank"></a>');
            clearInterval(checkExist);
          }
        }, 100);
      }
      reader.readAsDataURL(blob);
      success(imgSrc);
      (window.webkitURL || window.URL).revokeObjectURL(imgSrc);
    }
    printApiResponse(url, this.status, responseText);
  };
  if ($('#radio-upload-local').is(':checked')) {
    fd = new FormData();
    fd.append('userfile', $('#f_file_local')[0].files[0]);
  }
  oReq.send(fd);
}