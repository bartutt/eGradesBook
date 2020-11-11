<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
 
  
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
        <div class = "col m-3 modul rounded shadow-sm">
          <div class = "header">
            <h2 class="display-4"><?php echo $displayer->displayPersonName($_POST['id']);?></h2>
          </div>
 
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Details</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="attendance-tab" aria-selected="false">Attendance</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="marks-tab" data-toggle="tab" href="#marks" role="tab" aria-controls="marks" aria-selected="false">Marks</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">Notes</a>
              </li>
            </ul>
      
              <div class="tab-content">
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                  <?php $displayer->displayPersonDetails($_POST['id']);?>
                </div>
                <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                  <p class="lead">Select month:</p>
                    <select id = "inputAttendance" name = "value" class = "form-control" form = "choose_month">
                      <option value = '-01-'>january</option>
                      <option value = '-02-'>february</option>
                      <option value = '-03-'>march</option>
                      <option value = '-04-'>april</option>
                      <option value = '-05-'>may</option>
                      <option value = '-06-'>june</option>
                      <option value = '-09-'>september</option>
                      <option value = '-10-'>october</option>
                      <option value = '-11-'>november</option>
                      <option value = '-12-'>december</option>
                    </select>
                    <?php $displayer->displayAttendance($_POST['id'], $database->getCurrentYear());?>    
                </div>
                <div class="tab-pane fade" id="marks" role="tabpanel" aria-labelledby="marks-tab">           
                  <?php $displayer->displayStudentMarks($_POST['id'], $database->getCurrentYear());?>
                </div>
                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                  <?php $displayer->displayNotes($_POST['id'], $database->getCurrentYear());?>
                </div>    
            </div> 
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
<script src="js/filter_attendance.js"></script>
</body>
</html>



