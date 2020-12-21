<?php 
   require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
   require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.controller.php";
   require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.displayer.php";
   require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";
 $database = new DataBase();
 $displayer = new Displayer ($database);
 $controller = new Controller ($database, $displayer);

 $controller->htmlForm('set_supervisor_student');
 $controller->redirect('value');
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
        <div class = "col m-1 m-md-3 modul rounded shadow-sm p-3">
          <div class = "header">
            <h2 class="display-4">Parents</h2>
          </div>
            <p class="lead">Overview</p>
          <?php $displayer->displayPersons('parent');?>
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
<script src = "../js/selectize.js"></script>
</body>
</html>
