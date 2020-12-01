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
  $controller->htmlForm('set_marks');
  $controller->htmlForm('set_timetable');
  $class = $database->getStudentCurrentClass($_GET['person_id']); 
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
        <div class = "col m-3 modul rounded shadow-sm p-3">
          <div class = "header mb-3">
            <h2 class="display-4">Student: <?php echo $displayer->displayPersonName($_GET['person_id']);?></h2>  
            <h2 class="display-4">Class: <?php echo $class[0]['name']?></h2>
          
          </div>      
          <?php
                echo $controller->getForms();      

                if (!empty ($_POST['action'])) {
                  $action = explode('_', $_POST['action']);                 
                  
                  $controller->handleRequest ($_POST['action'], $_POST[$action[1]]);   
                  $displayer->displayErrors();
                  $displayer->displaySuccess();  
                          
                }else {
                      $controller->getTab($_GET['tab']);
                }
              ?>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link <?php echo $controller->tab['details'] ?>" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">
                  <span class = "d-none d-md-block">
                    Details
                  </span>
                  <i class="fas fa-user d-md-none"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo $controller->tab['attendance'] ?>" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="attendance-tab" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Attendance
                  </span>
                  <i class="fas fa-clipboard-list d-md-none"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo $controller->tab['marks'] ?>" id="marks-tab" data-toggle="tab" href="#marks" role="tab" aria-controls="marks" aria-selected="false">
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
                <a class="nav-link <?php echo $controller->tab['notes'] ?>" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Notes
                  </span>
                  <i class="fas fa-sticky-note d-md-none"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo $controller->tab['lessons'] ?>" id="lessons-tab" data-toggle="tab" href="#lessons" role="tab" aria-controls="lessons" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Lesson plan
                  </span>
                  <i class="fas fa-chalkboard-teacher d-md-none"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo $controller->tab['events'] ?>" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Events
                  </span>
                  <i class="far fa-calendar-check d-md-none"></i>
                </a>
              </li>
            </ul>
      
              <div class="tab-content">
                <div class="tab-pane fade <?php echo $controller->tab['details_show'] ?>" id="details" role="tabpanel" aria-labelledby="details-tab">
                  <?php $displayer->displayPersonDetails($_GET['person_id']);?>
                </div>
                <div class="tab-pane fade <?php echo $controller->tab['attendance_show'] ?>" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">      
                  
                  <div class = "row px-3"> 
                  <form id = "get_att_period" method = "get" action = "<?php $_SERVER['REQUEST_URI']?>">
                    <input name = "person_id" type = "hidden" value = "<?php echo $_GET['person_id'] ?>">
                    <input name = "tab" type = "hidden" value = "attendance">
                  </form>      
                    <div class = "col-md-3">    
                      <label for="datepicker_from">Date from</label>
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
                      <label for="datepicker_to">Date to</label>
                      <input 
                        autocomplete="off" 
                        name = "date_to" 
                        form = "get_att_period"  
                        class="form-control" 
                        type="text" 
                        id="datepicker_to"
                        required>
                    </div>
                    <div class="col-md-3 p-0 align-self-end">
                      <button form = "get_att_period" class = "btn btn-secondary rounded-0 mt-1 mx-0 float-right float-md-left">Show</button>
                    </div>
                  </div>
                  <?php
                    if (!empty ($_GET['date_from']) && !empty ($_GET['date_from'])) {
                      $displayer->displayAttendance($_GET['person_id'], $_GET['date_from'], $_GET['date_to']);
                      }
                  ?> 
                </div>  
                <div class="tab-pane fade <?php echo $controller->tab['marks_show'] ?>" id="marks" role="tabpanel" aria-labelledby="marks-tab">           
                  <?php $displayer->displayStudentMarks($_GET['person_id']);?>
                </div>
                <div class="tab-pane fade <?php echo $controller->tab['notes_show'] ?>" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                  <?php $displayer->displayNotes($_GET['person_id']);?>
                </div> 
                <div class="tab-pane fade <?php echo $controller->tab['lessons_show'] ?>" id="lessons" role="tabpanel" aria-labelledby="lessons-tab">
                  <div class = "row justify-content-center"> 
                    <div class = "col mt-3 text-center">
                      <?php $displayer->createTimetable($class[0]['id']);?> 
                    </div>        
                  </div> 
                </div> 
                <div class="tab-pane fade <?php echo $controller->tab['events_show'] ?>" id="events" role="tabpanel" aria-labelledby="events-tab">
                  <div class = "row"> 
                    <div class = "col mt-3 p-0 p-md-3">
                      <?php $displayer->displayEvents($class[0]['id']);?>   
                    </div>
                  </div>        
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
<script src="js/datepicker.js"></script>
<script src="js/edit_field.js"></script>
</body>
</html>



