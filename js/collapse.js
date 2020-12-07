  $('.collapse').on('shown.bs.collapse', function(e) {
    var $col = $(this).closest('.collapse');
    $('html,body').animate({
      scrollTop: $col.offset().top -100
    }, 500);
  });

