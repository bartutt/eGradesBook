<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('set_marks');
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
        <form id = "get_marks" method = "get" action = "<?php $_SERVER['REQUEST_URI']?>">
        </form>
          <div class = "header">
            <h2 class="display-4">Marks</h2>
            <?php
                echo $controller->getForms();
                if (!empty ($_POST['action']) && (!empty ($_POST['marks'])) ) {
                  
                  $controller->handleRequest ($_POST['action'], $_POST['marks']);
                  $displayer->displayErrors();
                  $displayer->displaySuccess();
                }
              ?>
          </div>
            <div class="form-row">
              <div class="col-md-3">
                <label for="personId">Choose student</label>
                <select id = "personId" name = "person_id" form = "get_marks" class="form-control" required>
                  <?php $displayer->displayPersonsSelect('student', $_GET['person_id']);?>
                </select>
              </div>
              <div class="col-md-3">
                <label for="subjects">Choose subject</label>
                <select id = "subjects" name = "subject" form = "get_marks" class="form-control" required>
                  <?php $displayer->displaySubjectsSelect($_GET['subject'], 'subject_name');?>
                </select>
              </div>
              <div class="col-md-3 align-self-end">          
                <button form = "get_marks" class="btn btn-success rounded-0 mt-1 mx-1 float-right float-md-left" type="submit">search</button>
              </div>
            </div>
        </div>
      </div>
      <div class = "row justify-content-center">
        <div class = "col-lg-11 m-1 m-md-3 modul rounded shadow-sm">
          <?php
           if (!empty ($_GET['person_id'])) {

            $displayer->displayStudentMarks($_GET['person_id'], $_GET['subject']);
      
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
<script src = "js/datepicker.js"></script>
</body>
</html>
