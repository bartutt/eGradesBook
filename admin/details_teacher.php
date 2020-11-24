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
        <div class = "col m-3 modul rounded shadow-sm p-3">
          <div class = "header">
            <h2 class="display-4"><?php echo $displayer->displayPersonName($_GET['person_id']);?></h2>
          </div>
 
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Details</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id=subjects-tab" data-toggle="tab" href="#subjects" role="tab" aria-controls="subjects-tab" aria-selected="false">Subjects</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="classes-tab" data-toggle="tab" href="#classes" role="tab" aria-controls="classes" aria-selected="false">Classes</a>
              </li>
            </ul>
      
              <div class="tab-content">
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                  <?php $displayer->displayPersonDetails($_GET['person_id']);?>
                </div>
                <div class="tab-pane fade" id="subjects" role="tabpanel" aria-labelledby="subjects-tab">
                  <?php $displayer->displayTeacherSubjects($_GET['person_id']);?>
                </div>
                <div class="tab-pane fade" id="classes" role="tabpanel" aria-labelledby="classes-tab">           
                  <?php $displayer->displayTeacherClasses($_GET['person_id']);?>
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



