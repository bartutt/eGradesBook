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
    <div class = "header"><h2>Settings</h2></div>
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
  <div id="scroll_years">
      <button style = "border-left: 4px solid rgb(216, 142, 4);" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#years" aria-expanded="true">
        <h5>Year manage</h5>
      </button>
    
    <div id="years" class="collapse" data-parent="#scroll_years">  
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
  </div>
<!-- years settings -->



<!-- lesson times settings -->
  <div id="lesson_times">   
      <button style = "border-left: 4px solid rgb(245, 66, 53);" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#lessons" aria-expanded="true">
      <h5>Lesson times</h5>
      </button>  
    <div id="lessons" class="collapse" data-parent="#lesson_times">
        <p class="lead">Current lesson times:</p>
      <div class="form-group">
        <?php $displayer->displayLessonTimesEdit();?>
      </div>
    </div>
  </div>
<!-- lesson times settings -->


<!-- marks settings -->
  <div id="scroll_marks">
    <button style = " border-left: 4px solid #4285F4" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#marks" aria-expanded="true">
      <h5>Assessment</h5>
    </button>
  
    <div id="marks" class="collapse" data-parent="#scroll_marks">
      <div class="row">
        <div class="col-sm-6">
          <p class="lead">Edit existing categories</p>
          <?php $displayer->displayMarksCat();?> 
        </div>

        <div class="col-sm-6">
          <p class="lead">Add new category</p>
          <input type = "text" class="form-control" name = "value" form = "add_mark_cat" placeholder = "category" required>
          <button class="button" form = "add_mark_cat" >add</button>
        </div>
      </div>
    </div>
  </div>
<!-- marks settings -->

<!-- person status settings -->
<div id="status_scroll">
    <button style = " border-left: 4px solid seagreen" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#status" aria-expanded="true">
      <h5>Person status</h5>
    </button>
    
  <div id="status" class="collapse" data-parent="#status_scroll">
 
    <div class="form-group">
      <label for="schoolYear">Add new year</label>
      <input  type = "text" class="form-control" name = "year" form = "add" placeholder = "2020/2021" required>
    </div>
    
    <div class="form-group"> 
      <button class="button" form = "add" >add</button>
    </div>
    
    <div class="form-group">
      <label for="schoolYear">Set current year</label>
      <select id = "schoolYear" class = "form-control" form = "select" name = "year" >
      <?php  ?>
      </select>
    </div>
    
    <div class="form-group">
      <button class="button" form = "select" >set</button>
    </div>
  
  </div>
</div>
<!-- marks settings -->


</div>
<!-- main content -->



<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->


</body>
</html>
