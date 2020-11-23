<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('get_att_period');
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
            ?>
          <div class = "header">
            <h2 class="display-4">Attendance</h2>
          </div>
            <div class="form-row">
              <div class="col-sm-3">
                <select name = "student_id" form = "get_att_period" class="form-control" placeholder = "Student">
                  <?php $displayer->displayPersonsSelect('student');?>
                </select>
              </div>
              <div class="col-sm-3">
                <input autocomplete="off" name = "date_from" form = "get_att_period"  class="form-control" type="text" id="datepicker_from" placeholder = "From">
              </div>  
              <div class="col-sm-3">
                <input autocomplete="off" name = "date_to" form = "get_att_period"  class="form-control" type="text" id="datepicker_to" placeholder = "To">
              </div>
              <div class="col-md-3">
                <button form = "get_att_period" class="btn btn-success rounded-0" type="submit">search</button>
              </div>
            </div>
        </div>
      </div>
      <div class = "row justify-content-center">
        <div class = "col-10 m-3 modul rounded shadow-sm text-center">
          <?php
           if (!empty ($_POST['student_id'])) {
            $displayer->displayAttendance($_POST['student_id'], '', $_POST['date_from'], $_POST['date_to']);
           }
          ?>
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
<script src="js/tooltip.js"></script>
<script src = "js/selectize.js"></script>
<script src = "js/datepicker.js"></script>
</body>
</html>
