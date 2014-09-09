function hoverOverTooltip(el, e) {
  var title = $(el).attr('data-tooltip'),
      p = $('<p class="tooltip-el"></p>').text(title).appendTo('body');
  setTimeout(function() {
//    if (!$(el).parent().hasClass('action-active')) {
      p.fadeIn('slow');
      $('.tooltip-el').css({
        top: e.pageY - 70,
        left: e.pageX + 10
      });
//    }
  }, 600);
}

function hoverOutTooltip() {
  $('.tooltip-el').remove();
}