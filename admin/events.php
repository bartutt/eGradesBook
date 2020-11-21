<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);

  $controller->htmlForm('add_event');
?>

<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>

<body class="d-flex flex-column min-vh-100">
<?php include './div/admin_topnav.html'?>
<!-- main -->
<div class="container-fluid" >
  <div class = "row">  
    <!--first main col -->
    <?php include './div/leftbar.html'?>
    <!--end of first main col -->

    <!--second main col -->
    <div class = "col-lg-10 offset-lg-2 ">
      <div class = "row">
      <div class = "col-10 m-3 modul rounded shadow-sm p-3">
          <?php
          echo $controller->getForms();

          if (!empty ($_POST['action'])){
            $controller->handleRequest ($_POST['action'], '', $_POST['value']);
            $displayer->displayErrors();
            $displayer->displaySuccess();
            }
            ?>
          <div class = "header">
            <h2 class="display-4">Add event</h2>
          </div>
            <div class="form-row">
              <div class="col-sm-3">
                <select name = "value[]" form = "add_event" class="form-control">
                  <?php $displayer->displayClassesSelect();?>
                </select>
              </div>
              <div class="col-sm-3">
                <input name = "value[]" form = "add_event" class="form-control" type="text" id = "description" placeholder = "Description">
              </div>    
              <div class="col-sm-3">
                <input autocomplete="off" name = "value[]" form = "add_event"  class="form-control" type="text" id="datepicker" placeholder = "Date">
              </div>
              <div class="col-sm-3">
                <button form = "add_event" class="btn btn-success rounded-0" type="submit">add</button>
                <button class = "btn btn-outline-danger rounded-0" id = "showRemove" >Edit</button>
              </div>
            </div>
        </div>
      </div>
      <div class = "row justify-content-center">
        <div class = "col-10 m-3 modul rounded shadow-sm text-center">
            <div id="calendar"></div>
        </div>
      </div>
    </div>
    <!--end of second main col -->

  </div>
</div>
 <!--end main -->


<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->
<script src = "js/datepicker.js"></script>
<script src="js/delete_button.js"></script>
<?php require_once 'js/calendar-js.php'?>
<?php require_once 'js/mockData.php'?>
<?php require_once 'js/calendar.php'?>
</body>
</html>
