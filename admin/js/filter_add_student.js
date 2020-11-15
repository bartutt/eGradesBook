$(document).ready(function(){
  $('#search_person').hide();

  $("#searchInput").on("keyup", function() {
      $('#search_person').hide();
     var value = $(this).val().toLowerCase(); 

    $("#search_person tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    
    if (event.keyCode === 13) {
      event.preventDefault();
        $('#search_person').show();
    }

    $("#searchEnter").on("click", function() {
      $('#search_person').show();
    });   
  });
});