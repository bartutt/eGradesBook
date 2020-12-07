<?php 
   require_once '../functions/class.logger.php';
   require_once '../functions/class.controller.php';
   require_once '../functions/class.displayer.php';
   require_once '../functions/class.database.php';
   $database = new DataBase();
   $displayer = new Displayer ($database);
   $controller = new Controller ($database, $displayer);
   $controller->htmlForm('add_information');
   $controller->redirect('value');
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
    <?php include './div/leftbar.php'?>
    <!--end of first main col -->

    <!--second main col -->
    <div class = "col-lg-10 offset-lg-2 ">
      <div class = "row">
        <div class = "col">
          <div class = "row">
            <div class = "header col m-1 m-md-3 modul rounded shadow-sm p-3">
              <h2 class="display-4 m-0">Dashboard</h2>     
              <?php 
                    echo $controller->getForms();
                    $displayer->displayResult();
              ?>          
            </div>
          </div>

          <div class = "row">
            <a href = "teachers.php" class = "col-lg modul-green text-white rounded shadow-sm p-3 m-1 ml-lg-3">
              <i class="fas fa-user-friends fa-3x float-right"></i>
              <span class = "modul"><?php echo $database->countPersons('teacher');?> teachers</span>
            </a>

            <a href = "students.php" class = "col-lg modul-orange text-white rounded shadow-sm p-3 m-1">
              <i class="fas fa-plus fa-3x float-right"></i>
              <span class = "modul"><?php echo $database->countNewPersons('student');?> new students</span>
            </a>
 
            <a href = "students.php" class = "col-lg modul-dark text-white rounded shadow-sm p-3 m-1">
              <i class="fas fa-user-friends fa-3x float-right"></i>
              <span class = "modul"><?php echo $database->countPersons('student');?> total</span>
            </a>

            <a href = "students.php" class = "col-lg modul-red text-white rounded shadow-sm p-3 m-1 mr-lg-3 ">
              <i class="fas fa-user-graduate fa-3x float-right"></i>
              <span class = "modul"><?php echo $database->countPersons('graduated');?> graduated</span>
            </a>
          </div>
        
          <div class = "row">
            <a href = "classes.php" class = "col-md-3 m-1 m-md-3 modul rounded shadow-sm p-0 chart-col">
              <div id="chartClasses" class = "chart"></div>
            </a>
            <div class = "col-md m-1 m-md-3 modul rounded shadow-sm p-3">
              <div class = "header">
                <h2 class="display-4">Information board</h2>
              </div>
                <?php          
                    $displayer->displayInformationBoard();
                ?>  
                <button type="button" class="btn btn-success rounded-0 mt-1 mx-1 float-right" data-toggle="modal" data-target="#addInformation">
                    add
                </button>
                <button class = "btn btn-outline-danger rounded-0 mt-1 mx-1 float-right" id = "showRemove" >
                  Edit
                </button>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php include '../js/chart_classes.php'?>
<script src = "../js/datepicker.js"></script>
<script src="../js/delete_button.js"></script>
</body>
</html>
