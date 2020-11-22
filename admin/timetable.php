<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('set_timetable');
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
        <div class = "col-10 m-3 modul rounded shadow-sm p-3">
          <?php
            echo $controller->getForms();
              if (!empty ($_POST['action'])) {
                    
                $controller->handleRequest ($_POST['action'], '', $_POST['timetable']);
                $displayer->displayErrors();
                $displayer->displaySuccess();
                }
              ?>
          <div class = "header">
            <h2 class="display-4">Choose class</h2>
          </div>
          <div class = "form-row">
            <div class = "col-lg-3">
              <form id = "set_class" action = "<?php $_SERVER['REQUEST_URI'] ?>" method = "get">
                <select name = "class_id" class = "form-control" form = "set_class">
                  <?php 
                      $displayer->displayClassesSelect($_GET['class_id']); 
                  ?>
                </select>
              </form>
            </div>
              
            <div class = "col-lg-3">
              <button form = "set_class" class = "btn btn-secondary rounded-0" >Show</button>
            </div>
          </div>
        </div>
      </div>
      <div class = "row justify-content-center">
        <div class = "col-10 m-3 modul rounded shadow-sm text-center">
          <?php 
            if (!empty($_GET['class_id']))
              $displayer->createTimetable($_GET['class_id']); 
          ?>
        </div>
      </div>
    </div>
    <!--end of second main col -->

  </div>
</div>
 <!--end main -->
 <script src="js/edit_field.js"></script>
<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->
</body>
</html>
