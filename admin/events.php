<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);

  $controller->htmlForm('add_event');
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
          <?php
          echo $controller->getForms();

          if (!empty ($_POST['action'])){
            $controller->handleRequest ($_POST['action'], $_POST['value']);
            $displayer->displayErrors();
            $displayer->displaySuccess();
            }
            ?>
          <div class = "header">
            <h2 class="display-4">Add event</h2>
          </div>
            <div class="form-row">
              <div class="col-md-1">
                <label for="class">Class</label>
                <select id = "class" name = "value[]" form = "add_event" class="form-control" required>
                  <?php $displayer->displayClassesSelect();?>
                </select>
              </div>
              <div class="col-md-2">
                <label for="title">Title</label>
                <input id = "title" name = "value[]" form = "add_event" class="form-control" type="text" id = "title" required>
              </div>   
              <div class="col-md-4">
                <label for="event-description">Description</label>
                <input id = "event-description" name = "value[]" form = "add_event" class="form-control" type="text" id = "description" required>
              </div>    
              <div class="col-md-2">
                <label for="datepicker">Choose date</label>
                <input autocomplete="off" name = "value[]" form = "add_event"  class="form-control" type="text" id="datepicker" required>
              </div>
              <div class="col-md-3 align-self-end">
                <button form = "add_event" class="btn btn-success rounded-0 mt-1 mx-1 float-right float-md-left" type="submit">Add</button>
                <button class = "btn btn-outline-danger rounded-0 mt-1 mx-1 float-right float-md-left" id = "showRemove" >Edit</button>
              </div>
            </div>
        </div>
      </div>
      <div class = "row">       
        <div class = "col-lg-6 mx-3 modul rounded shadow-sm p-3">
          <form id = "set_class" action = "<?php $_SERVER['REQUEST_URI'] ?>" method = "get">
          <div class = "row px-3">       
            <div class = "col-3 p-0">        
              <label for="set_class">Choose class:</label>                 
              <select name = "class_id" class = "form-control" form = "set_class" required>
              <?php 
                $displayer->displayClassesSelect($_GET['class_id']); 
              ?>
              </select>
            </div>

            <div class="col-3 align-self-end">
              <button form = "set_class" class = "btn btn-secondary rounded-0 mx-0 mt-1 float-left">Show</button>
            </div>
          </div>   
          </form>    
        </div>
      </div>

      <div class = "row">
        <div class = "col-lg-6 m-3">
          <?php 
          if (!empty($_GET['class_id'])) {
           
            $displayer->displayEvents($_GET['class_id']);
          
          } else echo '<b>No class choosed</b>';
          ?>
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
<script src = "js/datepicker.js"></script>
<script src="js/delete_button.js"></script>
</body>
</html>
