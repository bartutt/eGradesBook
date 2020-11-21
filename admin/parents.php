<?php 
 session_start();
 require_once './functions/class.controller.php';
 require_once './functions/class.displayer.php';
 require_once './functions/class.database.php';
 $database = new DataBase();
 $displayer = new Displayer ($database);
 $controller = new Controller ($database, $displayer);

 $controller->htmlForm('set_supervisor_student');
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
        <div class = "col-sm-10 m-3 modul rounded shadow-sm p-3">
          <?php
          echo $controller->getForms();

          if (!empty ($_POST['action'])){
            $controller->handleRequest ($_POST['action'], '', $_POST['value']);
            $displayer->displayErrors();
            $displayer->displaySuccess();
            }
            ?>
          <div class = "header">
            <h2 class="display-4">Assign student - parent</h2>
          </div>
            <div class="form-row">
              <div class="col-sm-4">
                <select name = "value[]" form = "set_supervisor_student" class="form-control" placeholder = "Find student">
                <option value=""></option>  
                  <?php $displayer->displayPersonsSelect('student');?>
                </select>
              </div>
              <div class="col-sm-4">
                <select name = "value[]" form = "set_supervisor_student" class="form-control" placeholder = "Find parent">  
                  <?php $displayer->displayPersonsSelect('parent');?>      
                </select>
              </div>
              <div class="col">
                <button form = "set_supervisor_student" class="btn btn-success rounded-0" type="submit">assign</button>
              </div>
            </div>
        </div>
      </div>
      <div class = "row">
        <div class = "col m-3 modul rounded shadow-sm p-3">
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
<?php include './div/footer.html'?>
<!-- Footer -->
<script src = "js/selectize.js"></script>
</body>
</html>
