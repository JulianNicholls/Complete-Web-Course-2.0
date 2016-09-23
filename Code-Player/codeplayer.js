$(function() {
  let panels = $('.panel').length;

  $('.panel').width((99 / panels) + "%");
  $('.panel').height($(window).height() - $('#header').height() - 20);

  $('.toggle-button').click(function () {
    $(this).toggleClass('active');
  });
});
