$( function() {
    $( "#datepicker" ).datepicker();

    $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  } );

  $( function() {
    $( "#datepicker_from" ).datepicker();

    $( "#datepicker_from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  } );

  $( function() {
    $( "#datepicker_to" ).datepicker();

    $( "#datepicker_to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  } );

  $( function() {
    $( "#birth_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "1940:2015"
    });

    $( "#birth_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  } );