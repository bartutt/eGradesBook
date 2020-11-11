$(document).ready(function($) {
    $('#attendanceTable').hide();
    
    $('#inputAttendance').change( function(){
      var selection = $(this).val();
      $('table')[selection? 'show' : 'hide']();
      
      if (selection) {
        $.each($('#attendanceTable tbody tr'), function(index, item) {
          $(item)[$(item).is(':contains('+ selection  +')')? 'show' : 'hide']();
        });
      }
        
    });
});