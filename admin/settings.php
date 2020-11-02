<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

?>

<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>

<!-- head -->
<body>


<!-- topnav -->
<?php include './div/admin_topnav.html'?>
<!-- topnav -->



<!-- header -->
<div class="container" style="margin-top:30px">
   
  <!-- content -->
  <div class="row">
    <div class = "header"><h2 class="display-4">Settings</h2></div>
  </div>
  <div class="row">
    <small class="text-muted">Here you can add new year, change lesson times, manage person status, marks categories or change current year.</small>
  </div>
  <!-- content -->
 
</div>
<!-- header -->


<!-- CONTROLLER -->
<?php
  $database = new DataBase();
  $controller = new Controller ($database);

  $controller->htmlForm('add_year');
  $controller->htmlForm('set_year');
  $controller->htmlForm('add_mark_cat');
  $controller->htmlForm('add_role_status');

  echo $controller->getForms();

  $displayer = new Displayer ($database);


  if (!empty ($_POST)){
    $controller->handleRequest ($_POST['action'], $_POST['old_value'], $_POST['value']);
    $displayer->displayErrors();
    $displayer->displaySuccess();
  }

?>
<!-- CONTROLLER -->


<!-- main content -->
<div class="container" style="margin-top:30px">


<!-- years settings -->
    <button aria-controls="years" style = "border-left: 4px solid rgb(216, 142, 4);" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#years" aria-expanded="false">
      <h5>Year manage</h5>
    </button>
    
    <div id="years" class="collapse">  
      <div class="row">
        <div class="col-sm-6">
          <p class="lead">Add new year</p>
          <input type = "text" class="form-control" name = "value" form = "add_year" placeholder = "2020/2021" required>
          <button class="button" form = "add_year" >add</button>
        </div>
        <div class="col-sm-6">
          <p class="lead">Set current year</p>
          <select class = "form-control" form = "set_year" name = "value" >
          <?php $displayer->displayYearsSelect();?>
          </select>
          <button class="button" form = "set_year" >set</button>
        </div>
      </div>
    </div>
<!-- years settings -->



<!-- lesson times settings -->
    <button aria-controls="lessons" style = "border-left: 4px solid rgb(245, 66, 53);" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#lessons" aria-expanded="false">
      <h5>Lesson times</h5>
      </button>  
    <div id="lessons" class="collapse">
        <p class="lead">Current lesson times:</p>
      <div class="form-group">
      <?php $displayer->displayContentAsButton('getLessonTimes', '$lesson', 'lesson', 'set_lesson_time');?>
      </div>
    </div>
<!-- lesson times settings -->

<!-- marks settings -->
    <button aria-controls="marks" style = " border-left: 4px solid #4285F4" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#marks" aria-expanded="false">
      <h5>Assessment</h5>
    </button>
    <div id="marks" class="collapse">
      <div class="row">
        <div class="col-sm-6">
          <p class="lead">Edit existing categories</p>
          <?php $displayer->displayContentAsButton('getMarksCat', '$marks', 'mark', 'set_mark_cat');?> 
        </div>

        <div class="col-sm-6">
          <p class="lead">Add new category</p>
          <input type = "text" class="form-control" name = "value" form = "add_mark_cat" placeholder = "category" required>
          <button class="button" form = "add_mark_cat" >add</button>
        </div>
      </div>
    </div>
 
<!-- marks settings -->


<!-- person status settings -->
    <button aria-controls="status" style = " border-left: 4px solid seagreen" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#status" aria-expanded="false">
      <h5>Person status</h5>
    </button>
    
      <div id="status" class="collapse">
        <div class="row">
          <div class="col-sm-6">
            <p class="lead">Available statuses/roles</p>
            <?php $displayer->displayContentAsButton('getRoleStatus', '$status', 'status', 'set_role_status');?> 
          </div>

          <div class="col-sm-6">
            <p class="lead">Add new category</p>
            <input type = "text" class="form-control" name = "value" form = "add_role_status" placeholder = "category" required>
            <button class="button" form = "add_role_status" >add</button>
          </div>
        </div>
      </div>
  <!-- marks settings -->


</div>
<!-- main content -->


<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->
<script>
  $('.collapse').on('shown.bs.collapse', function(e) {
    var $col = $(this).closest('.collapse');
    $('html,body').animate({
      scrollTop: $col.offset().top -100
    }, 500);
  });

   </script>
</body>
</html>
