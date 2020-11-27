<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
 
  $controller->htmlForm('set_attendance');
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
      <form id = "get_att_period" method = "get" action = "<?php $_SERVER['REQUEST_URI']?>">
        </form>
        <div class = "col m-3 modul rounded shadow-sm p-3">
          <div class = "header mb-3">
            <h2 class="display-4 d-inline"><?php echo $displayer->displayPersonName($_GET['person_id']);?></h2>
            <button form = "set_attendance" class="btn btn-success rounded-0 float-right" type="submit">save</button>
          </div>      
          <?php
                echo $controller->getForms();
                if (!empty ($_POST['action'])) {
                  $controller->handleRequest ($_POST['action'], '', $_POST['attendance']);
                  $displayer->displayErrors();
                  $displayer->displaySuccess();
                }
              ?>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">
                  <span class = "d-none d-md-block">
                    Details
                  </span>
                  <i class="fas fa-user d-md-none"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="attendance-tab" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Attendance
                  </span>
                  <i class="fas fa-clipboard-list d-md-none"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="marks-tab" data-toggle="tab" href="#marks" role="tab" aria-controls="marks" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Marks
                  </span>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2-circle d-md-none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                      <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
                    </svg>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Notes
                  </span>
                  <i class="fas fa-sticky-note d-md-none"></i>
                </a>
              </li>
            </ul>
      
              <div class="tab-content">
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                  <?php $displayer->displayPersonDetails($_GET['person_id']);?>
                </div>
                <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                  <p class="lead">Select month:</p>
                    <select id = "inputAttendance" name = "value" class = "form-control m-3 w-50" form = "choose_month">
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
                    <?php $displayer->displayAttendance($_GET['person_id'], $database->getCurrentYear());?>    
                </div>
                <div class="tab-pane fade" id="marks" role="tabpanel" aria-labelledby="marks-tab">           
                  <?php $displayer->displayStudentMarks($_GET['person_id'], $database->getCurrentYear());?>
                </div>
                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                  <?php $displayer->displayNotes($_GET['person_id'], $database->getCurrentYear());?>
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



