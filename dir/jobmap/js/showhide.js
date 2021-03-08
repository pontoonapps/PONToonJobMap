document.addEventListener('DOMContentLoaded', function () {
    $('button').on('click', function () {
      $(this)
        .find('[data-fa-i2svg]')
        .toggleClass('fa-angle-down')
        .toggleClass('fa-angle-right');
    });
  });

var navBar = $('.navbar');
$(window).scroll(function () {
  var topPos = $(this).scrollTop();
  if (topPos > 100) {
    $(navBar).css('opacity', '0');
  } else {
    $(navBar).css('opacity', '1');
  }
});
