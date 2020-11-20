<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('set_timetable');
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
            
        for ($i = 0; $i <= 39; $i ++) {
          if ($_POST['subject'][$i] !== ''){
            $timetable[$i][] = $_POST['class'][$i];
            $timetable[$i][] = $_POST['subject'][$i];
            $timetable[$i][] = $_POST['teacher'][$i];
            $timetable[$i][] = $_POST['time'][$i];
            $timetable[$i][] = $_POST['day'][$i];
        }
        }
          
            $controller->handleRequest ($_POST['action'], '', $timetable);
            $displayer->displayErrors();
            $displayer->displaySuccess();
            }
            ?>
          <div class = "header">
            <h2 class="display-4">Timetable</h2>
            <button class = "btn btn-outline-danger rounded-0" id = "editField" >Edit</button>
            <button type = "submit" form = "set_timetable" class = "btn btn-outline-danger rounded-0" id = "editField" >Save</button>
          </div>
            
        </div>
      </div>
      <div class = "row justify-content-center">
        <div class = "col-10 m-3 modul rounded shadow-sm text-center">
          <?php $displayer->createTimetable('23');?>
        </div>
      </div>
    </div>
    <!--end of second main col -->

  </div>
</div>
 <!--end main -->
 <script src="js/edit_field.js"></script>
<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->
</body>
</html>
