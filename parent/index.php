<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.controller.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.displayer.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
 
  $class = $database->getStudentCurrentClass($_SESSION['person_id']); 
  $controller->getTab();
  
  $controller->redirect();
  $login = new Logger($database);
  $login->isLogged('parent');
?>


<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>

<body class="d-flex flex-column min-vh-100">
<?php include './div/parent_topnav.html'?>
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
            <h2 class="display-4">Information board</h2>
          </div>
        <?php $displayer->displayInformationBoard();?> 
        </div>        
      </div> 
      <div class = "row">
        <div class = "col m-1 m-md-3 modul rounded shadow-sm p-3">
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
                <a class="nav-link" id="children-tab" data-toggle="tab" href="#children" role="tab" aria-controls="children-tab" aria-selected="false">
                  <span class = "d-none d-md-block">
                    Children
                  </span>
                  <i class="fas fa-child d-md-none"></i>
                </a>
              </li>
            </ul>
      
              <div class="tab-content">
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                  <?php $displayer->displayPersonDetails($_SESSION['person_id'], 'true');?>
                </div>
                <div class="tab-pane fade" id="children" role="tabpanel" aria-labelledby="children-tab">
                  <?php $displayer->displaySupervisorStudent($_SESSION['person_id']);?>
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
<script src="../js/datepicker.js"></script>
<script src="../js/edit_field.js"></script>
</body>
</html>



