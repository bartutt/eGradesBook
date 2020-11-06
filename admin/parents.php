<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';

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
    <div class = "header"><h2 class="display-4">Parents</h2></div>
  </div>
  <!-- content -->
 
</div>
<!-- header -->


<!-- CONTROLLER -->
<?php
  $database = new DataBase();
  $controller = new Controller ($database);
  $student = new RandomPerson;

  $controller->htmlForm('details');
  

  echo $controller->getForms();

  $displayer = new Displayer ($database);


  if (!empty ($_POST)){
    $controller->handleRequest ($_POST['action'], $_POST['old_value'], $_POST['student']);
    $displayer->displayErrors();
    $displayer->displaySuccess();
  }
?>
<!-- CONTROLLER -->


<!-- main content -->
<div class="container">
  <div class="row">
    <div class="col 12">  
        <p class="lead">Overview</p>
          <?php $displayer->displayPersons('parent');?>
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
