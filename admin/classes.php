<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $controller->htmlForm('add_class');
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
        <div class = "col m-3 modul rounded shadow-sm p-3">
          <div class = "header">
            <h2 class="display-4">Add class</h2>
          </div>
            <?php
                echo $controller->getForms();

                if (!empty ($_POST['action'])) {
                  $controller->handleRequest ($_POST['action'], $_POST['old_value'], $_POST['class']);
                  $displayer->displayErrors();
                  $displayer->displaySuccess();
                }
              ?>
            <div class="form-row">
              <div class="col-sm-2">
              <label for="class-name">Class name</label>
                <input form = "add_class" name = "class[]" id = "class-name" type="text" class="form-control" placeholder="1c">
              </div>
              <div class="col-sm-2">
                <label for="teacher">Teacher</label>
                  <select form = "add_class" name = "class[]" id="teacher" class="form-control">
                    <?php $displayer->displayPersonsSelect('teacher');?>
                  </select>
              </div>
              <div class="col-sm-2">
                <label for="profile">Profile</label>
                  <select form = "add_class" name = "class[]" id="profile" class="form-control">
                    <?php $displayer->displayProfilesSelect();?>
                  </select>
              </div>  
              <div class="col-sm-2">
                <label for="profile">School year</label>
                  <select form = "add_class" name = "class[]" id="profile" class="form-control">
                    <?php $displayer->displayYearsSelect();?>
                  </select>
              </div>
              <div class="col-sm-2 align-self-end">
                    <button form = "add_class" class="btn btn-success rounded-0" type="submit">add</button>
              </div>
            </div>
        </div>
      </div>
      <div class = "row">
        <div class = "col-md-8 m-3 modul rounded shadow-sm p-3">
          <div class = "header">
            <h2 class="display-4">Classes <?php echo $database->getCurrentYear();?></h2>
          </div>
          <p class="lead">Overview</p>
          <?php $displayer->displayClasses($database->getCurrentYear());?>
        </div>
          <div class = "col-md-3 m-3 modul rounded shadow-sm p-0 chart-col">
            <div id="chartClasses" class = "chart"></div>
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
<?php include './js/chart_classes.php'?>
<script src="js/delete_button.js"></script>
</body>
</html>
