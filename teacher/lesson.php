<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.controller.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.displayer.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";
  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('start_lesson');
  $controller->htmlForm('set_attendance');
  $controller->htmlForm('add_marks');
  $controller->htmlForm('set_marks');
  $controller->htmlForm('finish_lesson', 'lesson');
  $controller->htmlForm('add_note');
  $login = new Logger($database);
  $login->isLogged('teacher');
  if (!empty ($_POST['action'])) {

    $action = explode('_', $_POST['action']);                              
    $controller->handleRequest ($_POST['action'], $_POST[$action[1]]);    
  }   

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
      <?php 
        echo $controller->getForms();        
            $controller->addMark(); 
            $controller->addNote(); 
        ?>
      <div class = "row justify-content-center">
        <div class = "col-md-10 m-1 m-md-3 modul rounded shadow-sm p-3">
          <?php 
            $displayer->displayResult(); 
            $controller->startLesson(); 
          ?>          
        </div>
      </div>
      
    </div>
    <!--end of second main col -->

  </div>
</div>
 <!--end main -->


<!-- Footer -->
<?php include './div/footer.html'; unset ($_SESSION['tab']);?>
<script src="../js/tooltip.js"></script>
<!-- Footer -->
</body>
</html>
