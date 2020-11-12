<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';
  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
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
        <div class = "col-md-8 m-3 modul rounded shadow-sm">
          <div class = "header">
            <h2 class="display-4">Classes <?php echo $database->getCurrentYear();?></h2>
          </div>
          <p class="lead">Overview</p>
          <?php $displayer->displayClasses($database->getCurrentYear());?>
        </div>
        <div class = "col-md-3 m-3 modul rounded shadow-sm p-0">
          <div id="chart_div1" class = "chart"></div>
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
<?php include './js/classes_chart.php'?>

</body>
</html>
