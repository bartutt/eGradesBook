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
        <div class = "col-sm-10 m-1 m-md-3 modul rounded shadow-sm p-3">
        <?php 
                    echo $controller->getForms();
                    $displayer->displayResult();
              ?>  
          <div class = "header">
            <h2 class="display-4">Assign student - parent</h2>
          </div>
            <div class="form-row">
              <div class="col-sm-4">
                <label for="student">Enter student</label>
                <select id = "student" name = "value[]" form = "set_supervisor_student" class="form-control" required>
                  <?php $displayer->displayPersonsSelect('student');?>
                </select>
              </div>
              <div class="col-sm-4">
                <label for="student">Enter parent</label>
                <select id = "parent" name = "value[]" form = "set_supervisor_student" class="form-control" required>  
                  <?php $displayer->displayPersonsSelect('parent');?>      
                </select>
              </div>
              <div class="col align-self-end">
                <button form = "set_supervisor_student" class="btn btn-success rounded-0 mt-1 float-right float-md-left" type="submit">assign</button>
              </div>
            </div>
        </div>
      </div>
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
