<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';

  $database = new DataBase();
  $controller = new Controller ($database);
  $displayer = new Displayer ($database);

?>


<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>

<!-- head -->
<body class="d-flex flex-column min-vh-100">


<!-- topnav -->
<?php include './div/admin_topnav.html'?>
<!-- topnav -->


<!-- header -->
<div class="container" >
   
  <!-- content -->
  <div class="row">
    <div class = "header">
      <h2 class="display-4">
        <?php $displayer->displayStudentName($_POST['id']);?>
      </h2>
    </div>
  </div>
  <!-- content -->
 
</div>
<!-- header -->


<!-- main content -->
<div class="container">
  <div class="row">
    <div class="col 12">  
        <p class="lead">Details</p>
          <?php $displayer->displayStudentDetails($_POST['id']);?>
    </div> 
  </div>
</div>
<!-- main content -->

<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->

<script src="js/collapse.js"></script>

</body>
</html>
