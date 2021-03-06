<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.controller.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.displayer.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->getTab();
  
  $controller->redirect();
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
        <div class = "col m-1 m-md-3 modul rounded shadow-sm p-3">
          <div class = "header">
            <h2 class="display-4">
              Teacher: <?php $displayer->displayPersonName($_GET['person_id']);?>
            </h2>
          </div>
          <?php 
                    echo $controller->getForms();
                    $displayer->displayResult();
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
                <a class="nav-link" id=subjects-tab" data-toggle="tab" href="#subjects" role="tab" aria-controls="subjects-tab" aria-selected="false">
                <span class = "d-none d-md-block">
                    Subjects
                  </span>
                  <i class="fas fa-book d-md-none"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="classes-tab" data-toggle="tab" href="#classes" role="tab" aria-controls="classes" aria-selected="false">
                <span class = "d-none d-md-block">
                    Classes
                  </span>
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-layout-text-window-reverse d-md-none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                    <path fill-rule="evenodd" d="M5 15V4H4v11h1zM.5 4h15V3H.5v1zM13 6.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm0 3a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm0 3a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                  </svg>
                </a>
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
<?php include './div/footer.html'; unset ($_SESSION['tab']);?>
<!-- Footer -->

<script src="../js/tooltip.js"></script>
<script src="../js/filter_attendance.js"></script>
</body>
</html>



