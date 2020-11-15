<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
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
        <div class = "col-sm-8 m-3 modul rounded shadow-sm p-3 chart-col">
        <?php              
                if (!empty ($_POST['action'])) {
                  $controller->handleRequest ($_POST['action'], $_POST['student_id'], $_GET['class_id']);
                  $displayer->displayErrors();
                  $displayer->displaySuccess();
                }          
        ?>
          <div class = "header">
            <h2 class="display-4">Add student</h2>
          </div>
            <div class="row">
              <div class="col-sm-8">
                <input id = "searchInput" type="text" class="form-control" placeholder="name/surname/id...">
              </div>
              <div class="col-sm-2 align-self-end">
                    <button id = "searchEnter" class="btn btn-success rounded-0" type="button">search</button>
              </div> 
            </div>        
            <div class="row m-2">
              <div class="col short-col">
                <?php $displayer->searchPersonButton('student');?>               
              </div> 
            </div>
        </div>
        <div class = "col-md-3 m-3 modul rounded shadow-sm p-0 chart-col">
            <div id="chartClassDetails" class = "chart"></div>
        </div>
      </div>
      <div class = "row">
          <div class = "col-md-8 m-3 modul rounded shadow-sm p-3 ">      
            <?php $displayer->displayClassDetails($_GET['class_id']);?>
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
<script src="js/filter_add_student.js"></script>
<?php include './js/chart_class_details.php'?>
<script src="js/delete_button.js"></script>
</body>
</html>
