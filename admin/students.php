<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);

  $controller->htmlForm('details');
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
        <div class = "col-md-7 m-1 m-md-3 modul rounded shadow-sm p-3">
          <div class = "header">
            <h2 class="display-4">Students</h2>
          </div>
            <p class="lead">Overview</p>
          <?php $displayer->displayPersons('student');?>
        </div>
        <div class = "col-md-4">
          <div class = "row">
            <a href = "index.php" class = "col m-1 m-md-2 mt-md-3 modul-orange text-white rounded shadow-sm p-3">
              <i class="fas fa-plus fa-3x float-right"></i><span class = "modul"><?php echo $database->countNewPersons('student');?> new students</span>
            </a>
          </div>
          <div class = "row">
            <a href = "index.php" class = "col m-1 m-md-2 modul-dark text-white rounded shadow-sm p-3">
              <i class="fas fa-user-friends fa-3x float-right"></i><span class = "modul"><?php echo $database->countPersons('student');?> total</span>
            </a>
          </div>
          <div class = "row">
            <a href = "index.php" class = "col m-1 m-md-2 modul-red text-white rounded shadow-sm p-3">
              <i class="fas fa-user-graduate fa-3x float-right"></i><span class = "modul"><?php echo $database->countPersons('graduated');?> graduated</span>
            </a>
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
</body>
</html>
