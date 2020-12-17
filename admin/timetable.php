<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.controller.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.displayer.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('set_timetable');

  $controller->redirect('timetable');
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
        <div class = "col-md-10 m-1 m-md-3 modul rounded shadow-sm p-3">
        <?php 
                    echo $controller->getForms();
                    $displayer->displayResult();
              ?>     
          <div class = "header">
            <h2 class="display-4">Choose class</h2>
          </div>
          <div class = "form-row">
            <div class = "col-lg-3 ">
              <form id = "set_class" action = "<?php $_SERVER['REQUEST_URI'] ?>" method = "get">
                <label for = "set_class>">Choose class</label>
                <select id = "set_class" name = "class_id" class = "form-control" form = "set_class" required>
                  <?php 
                      $displayer->displayClassesSelect($_GET['class_id']); 
                  ?>
                </select>
              </form>
            </div>
              
            <div class = "col-lg-3 align-self-end">
              <button form = "set_class" class = "btn btn-secondary rounded-0 mt-1 mx-1 float-right float-md-left" >Show</button>
            </div>
          </div>
        </div>
      </div>
      <div class = "row justify-content-center">
        <div class = "col-md-10 m-1 m-md-3 modul rounded shadow-sm text-center">
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
 <script src="../js/edit_field.js"></script>
<!-- Footer -->
<?php include './div/footer.html'; unset ($_SESSION['tab']);?>
<!-- Footer -->
</body>
</html>
