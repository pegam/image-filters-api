jQuery(document).ready(function($) {
  $('#select_filter').on('change', function() {
    var form_id = 'if_' + $(this).val();
    $('form.show').removeClass('show').addClass('hide');
    $('form.hide').each(function() {
      if ($(this).attr('id') === form_id) {
        $(this).removeClass('hide');
        $(this).addClass('show');
      }
    });
  });

  $('input[type=button].submit').on('click', function() {
    var form = $(this).closest('form');
    var form_action = form.attr('action');
    form.find('input[type=text]').each(function() {
      if ($(this).val()) {
        if (form_action.slice(-1) !== '?') {
          form_action += '&';
        }
        form_action += $(this).attr('class') + '=' + $(this).val();
      }
    });
    form.find('input[type=checkbox]').each(function() {
      if (this.checked) {
        if (form_action.slice(-1) !== '?') {
          form_action += '&';
        }
        form_action += $(this).attr('class') + '=' + this.checked;
      }
    });
    form.find('select').each(function() {
      if ($(this).children('option:selected').val()) {
        if (form_action.slice(-1) !== '?') {
          form_action += '&';
        }
        form_action += $(this).attr('class') + '=' + $(this).children('option:selected').val();
      }
    });
    form.attr('action', form_action);
    form.submit();
  });
});