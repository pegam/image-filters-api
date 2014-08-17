$(function() {
  changeRadio();
  $('input:radio[name=f_upload]').on('change', function() {
    changeRadio();
  });
});

clentId = '53ecca8609d14';
apiKey = 'ddc366b21106b13347e9cba8e63056370735072e';

function changeRadio() {
  $('input:radio[name=f_upload]').each(function(i) {
    if ($(this).is(':checked')) {
      $('div#upload-' + $(this).val()).css('display', 'block');
    } else {
      $('div#upload-' + $(this).val()).css('display', 'none');
    }
  });
}
