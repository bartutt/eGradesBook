<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';

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
    <p>Here you can add new year, change lesson times, manage person status, marks categories or change current year.</p>
  </div>
<!-- content -->
 
</div>
<!-- header -->


<!-- FORMS  -->
<form id = "add_year" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
  <input type = "hidden" name = "action" value = "add_year">
</form >

<form id = "set_year" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
  <input type = "hidden" name = "action" value = "set_year">
</form >
<!-- FORMS  -->


<!-- CONTROLLER -->
<?php
  $controller = new Controller();
 
  if (!empty ($_POST))
    $controller->handleRequest ($_POST['action'], $_POST['year']);
?>
<!-- CONTROLLER -->

<!-- main content -->
<div class="container" style="margin-top:30px">

<!-- years settings -->
<div id="scroll_years">
    <button style = " border-left: 4px solid rgb(216, 142, 4);" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#years" aria-expanded="true">
      <h5>Year manage</h5>
    </button>
    
  <div id="years" class="collapse" data-parent="#scroll_years">
 
  <div class="form-group">
      <label for="schoolYear">Add new year</label>
      <input type = "text" class="form-control" name = "year" form = "add_year" placeholder = "2020/2021" required>
    </div>
    
    <div class="form-group"> 
      <button class="button" form = "add_year" >add</button>
    </div>
    <div class="form-group">
      <label for="schoolYear">Set current year</label>
      <select id = "schoolYear" class = "form-control" form = "set_year" name = "year" >
       <?php $displayer = new Displayer; $displayer->yearsSelect();?>
      </select>
    </div>
   
    <div class="form-group">
      <button class="button" form = "set_year" >set</button>
    </div>

  </div>
</div>
<!-- years settings -->

<!-- lesson times settings -->
<div id="lesson_times">
    <button style = " border-left: 4px solid rgb(245, 66, 53);" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#lessons" aria-expanded="true">
      <h5>Lesson times</h5>
    </button>
    
  <div id="lessons" class="collapse" data-parent="#lesson_times">
 
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
<!-- lesson times settings -->


<!-- marks settings -->
<div id="scroll_marks">
    <button style = " border-left: 4px solid rgb(33, 103, 253)" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#marks" aria-expanded="true">
      <h5>Marks</h5>
    </button>
    
  <div id="marks" class="collapse" data-parent="#scroll_marks">
 
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
      <?php ?>
      </select>
    </div>
    
    <div class="form-group">
      <button class="button" form = "select" >set</button>
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
