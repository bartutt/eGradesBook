<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';

  $database = new DataBase();
  $controller = new Controller ($database);
  $displayer = new Displayer ($database);
  
?>


<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>

<!-- head -->
<body class="d-flex flex-column min-vh-100">


<!-- topnav -->
<?php include './div/admin_topnav.html'?>
<!-- topnav -->


<!-- header -->
<div class="container" >
   
  <!-- content -->
  <div class="row">
    <div class = "header">
      <h2 class="display-4">
        <?php echo $displayer->displayPersonName('student', $_POST['id']);?>
      </h2>
    </div>
  </div>
  <!-- content -->
 
</div>
<!-- header -->


<!-- main content -->
<div class="container">

  <div class="row">
    <div class="col 12">  
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
          <?php $displayer->displayPersonDetails('student', $_POST['id']);?>
        </div>
        <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">...</div>
        <div class="tab-pane fade" id="marks" role="tabpanel" aria-labelledby="marks-tab">           
              <?php $displayer->displayStudentMarks($_POST['id'], $database->getCurrentYear());?>
        </div>
        <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
          <?php $displayer->displayNotes($_POST['id']);?>
        </div>
      
      </div>  
    </div> 
  </div>
</div>
<!-- main content -->

<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->

<script src="js/tooltip.js"></script>

</body>
</html>
