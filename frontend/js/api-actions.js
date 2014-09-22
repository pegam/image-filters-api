function createActionButton(action, description) {
  var a = '<li><a href="javascript:void(0)"';
  if (description) {
    a += ' data-tooltip="' + description + '" class="tooltip" onmouseover="hoverOverTooltip(this, event)" onmouseout="hoverOutTooltip(this)"';
  }
  a += ' onclick="apiAction(this)">' + action + '</a></li>';
  $('#api-actions > ul').append(a);
}

function apiAction(action) {
  hoverOutTooltip();
  $('.action-active').removeClass('action-active');
  $(action).parent().addClass('action-active');
  loadActionParams($.trim($(action).text()));
  $('#imgage-edited').addClass('no-display');
  $('#edited-image > div.save-img > a').parent().addClass('no-display');
  $('#submit-btn').removeAttr('disabled');
}

function loadActionParams(action) {
  if (!$.isEmptyObject(apiResourcesObj)) {
    $('#action-params').empty();
    var parent = $('#action-params');
    var actionObj = apiResourcesObj[resource]['actions'][action];
    addHttpMethodField(parent, actionObj['httpMethod']);
    addBr(parent);
    addParams(parent, actionObj['parameters'], action);
    addDescription(parent, actionObj['description']);
    addBr(parent);
    addLegend(parent);
  }
}

function addBr(parent) {
  parent.append('<br />');
}

function addDescription(parent, desc) {
  parent.append('<strong>Description:</strong> ' + desc);
  addBr(parent);
}

function addHttpMethodField(parent, method) {
  parent.append('<strong>Http method:</strong> ' + method);
  addBr(parent);
}

function addLegend(parent) {
  var legend = '<span class="text-color-red">*</span> <span class="small-text">- required field</span>';
  parent.append(legend);
  addBr(parent);
}

function addParams(parent, params, action) {
  for (var i in params) {
    if (i !== 'url') {
      var param = params[i];
      if (param['choice']) {
        addChoice(parent, i, param, action);
      } else {
        addParam(parent, i, param);
      }
    }
  }
}

function addParam(parent, name, param) {
  var id = 'f_' + name,
      el = '<input type="text" id="' + id + '" name="' + name + '" placeholder="' + capitaliseFirstLetter(param['type']) + '"',
      desc,
      br = '<br />',
      label = '<label for="' + id + '">' + name;
  if (param['description']) {
    el += ' data-tooltip="' + param['description'] + '" class="tooltip" onmouseover="hoverOverTooltip(this, event)" onmouseout="hoverOutTooltip(this)"';
  }
  el += ' />';
  if (param['min'] || param['min'] === 0) {
    desc = 'min = ' + param['min'];
  }
  if (param['max'] || param['max'] === 0) {
    if (desc) {
      desc += ', ';
    }
    desc += 'max = ' + param['max'];
  }
  if (desc) {
    label += ' <span class="small-text">(' + desc + ')</span>';
  }
  if (param['required']) {
    label += ' <span class="text-color-red">*</span>';
  }
  label += '</label>';
  el = label + br + el + br + br;
  parent.append(el);
}

function addChoice(parent, name, param, action) {
  if (action === 'filter') {
    addFilterChoice(parent, name, param);
  } else {
    addPlainChoice(parent, name, param);
  }
}

function addPlainChoice(parent, name, param) {
  var id = 'f_' + name,
      el = '<select id="' + id + '" name="' + name + '"',
      br = '<br />',
      label = '<label for="' + id + '">';
  if (param['description']) {
    el += ' data-tooltip="' + param['description'] + '" class="tooltip" onmouseover="hoverOverTooltip(this, event)" onmouseout="hoverOutTooltip(this)"';
  }
  el += '>';
  if (name === 'out') {
    label += 'resulting image format';
  } else {
    label += name;
  }
  if (param['required']) {
    label += ' <span class="text-color-red">*</span>';
  }
  label += '</label>';
  el += '<option value="" selected></option>';
  for (var i in param['choice']) {
    var val = param['choice'][i];
    if (name === 'out' && val === 'jpg') {
      continue;
    }
    el += '<option value="' + val + '">' + val + '</option>';
  }
  el += '</select>';
  el = label + br + el + br + br;
  parent.append(el);
}

function addFilterChoice(parent, name, param) {
  var id = 'f_' + name,
      el = '<select id="' + id + '" name="' + name + '"',
      br = '<br />',
      label = '<label for="' + id + '">';
  if (name === 'out') {
    label += 'resulting image format';
  } else {
    el += ' onchange="addFilterParams(this.value)"';
    label += name;
  }
  if (param['description']) {
    el += ' data-tooltip="' + param['description'] + '" class="tooltip" onmouseover="hoverOverTooltip(this, event)" onmouseout="hoverOutTooltip(this)"';
  }
  el += '>';
  if (param['required']) {
    label += ' <span class="text-color-red">*</span>';
  }
  label += '</label>';
  el += '<option value="" selected></option>';
  for (var i in param['choice']) {
    if (name === 'out') {
      var val = param['choice'][i];
      if (val === 'jpg') {
        continue;
      }
      el += '<option value="' + val + '">' + val + '</option>';
    } else {
      el += '<option value="' + i + '">' + i + '</option>';
    }
  }
  el += '</select>';
  el = label + br + el + br + br;
  parent.append(el);
  parent.append('<div id="filter-params"></div>');
}

function addFilterParams(filter) {
  $('f_out').val('');
  $('#filter-params').empty();
  $('#imgage-edited').addClass('no-display');
  $('#edited-image > div.save-img > a').parent().addClass('no-display');
  if (apiResourcesObj && apiResourcesObj[resource]['actions']['filter']['parameters']['name']['choice'][filter]['parameters']) {
    var parent = $('#filter-params');
    params = apiResourcesObj[resource]['actions']['filter']['parameters']['name']['choice'][filter]['parameters'];
    for (var i in params) {
      var param = params[i];
      addParam(parent, i, param);
    }
  }
}