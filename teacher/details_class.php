<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.controller.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.displayer.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";
  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->redirect('class_id', 'student_id');
  $login = new Logger($database);
  $login->isLogged('teacher');
?>

<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>
<body class="d-flex flex-column min-vh-100">
<?php include './div/teacher_topnav.html'?>
<!-- main -->
<div class="container-fluid" >
  <div class = "row">  
    <!--first main col -->
    <?php include './div/leftbar.html'?>
    <!--end of first main col -->

    <!--second main col -->
    <div class = "col-lg-10 offset-lg-2 ">
      <div class = "row">
        <div class = "col-md-6 m-1 m-md-3 modul rounded shadow-sm p-3 ">  
        <?php 
            echo $controller->getForms();
            $displayer->displayResult();       
            $displayer->displayClassDetails($_GET['class_id']);
            ?>
        </div> 
        <div class = "col-md-5 m-1 m-md-3">
          <div class = "row mt-3">
            <div class = "col modul rounded shadow-sm p-0 chart-col">
              <div id="chartClassDetails" class = "chart"></div>
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

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="../js/filter_add_student.js"></script>
<?php include '../js/chart_class_details.php'?>
<script src="../js/delete_button.js"></script>
</body>
</html>
