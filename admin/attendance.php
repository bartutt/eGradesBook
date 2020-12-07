<?php 
  require_once '../functions/class.logger.php';
  require_once '../functions/class.controller.php';
  require_once '../functions/class.displayer.php';
  require_once '../functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('set_attendance');
  $controller->redirect('attendance');
  $login = new Logger($database);
  $login->isLogged('admin');
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
      <div class = "col-md-10 m-1 m-md-3 modul rounded shadow-sm p-3">
        <form id = "get_att_period" method = "get" action = "<?php $_SERVER['REQUEST_URI']?>">
        </form>
          <div class = "header">
            <h2 class="display-4">Attendance</h2>
            <?php 
                    echo $controller->getForms();
                    $displayer->displayResult();
              ?> 
          </div>
            <div class="form-row">
              <div class="col-md-3">
                <label for="person-id">Choose student</label>
                <select name = "person_id" form = "get_att_period" class="form-control" required>
                  <?php $displayer->displayPersonsSelect('student', $_GET['person_id']);?>
                </select>
              </div>
              <div class="col-md-3">
                <label for="datepicker-from">Date from</label>
                <input 
                  autocomplete="off" 
                  name = "date_from" 
                  form = "get_att_period"  
                  class="form-control" 
                  type="text" 
                  id="datepicker_from"
                  required>
              </div>  
              <div class="col-md-3">
                <label for="datepicker-to">Date to</label>
                <input 
                  autocomplete="off" 
                  name = "date_to" 
                  form = "get_att_period"  
                  class="form-control" 
                  type="text" 
                  id="datepicker_to"
                  required>
              </div>
              <div class="col-md-3 align-self-end">          
                <button form = "get_att_period" class="btn btn-success rounded-0 mt-1 mx-1 float-right float-md-left" type="submit">search</button>
              </div>
            </div>
        </div>
      </div>
      <div class = "row justify-content-center">
        <div class = "col-lg-10 m-1 m-md-3 modul rounded shadow-sm text-center">
          <?php
           if (!empty ($_GET['person_id'])) {
            $displayer->displayAttendance($_GET['person_id'], $_GET['date_from'], $_GET['date_to']);
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

<script src="../js/tooltip.js"></script>
<script src = "../js/datepicker.js"></script>
</body>
</html>
