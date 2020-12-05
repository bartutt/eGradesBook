<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';
  
  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);
  $person = new RandomPerson;
  $controller->htmlForm('add_person');
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
        <div class = "col-md-8 m-1 m-md-3 modul rounded shadow-sm p-3">
          <div class = "header ">
            <h2 class="display-4">Add <?php echo $_GET['person']?></h2>
          </div>
            <?php
              echo $controller->getForms();

                if (!empty ($_POST['action'])){
                  $controller->handleRequest ($_POST['action'], $_POST['person']);
                  $displayer->displayErrors();
                  $displayer->displaySuccess();
                }
              ?>
            <table class = "table table-sm" >
              <tr>
		            <td >ID number</td >
                <td >
                  <input class = "form-control form-control-sm mt-1 mb-1"  form ="add_person"  type = "text" name = "person[]" required>
                  <small id="emailHelp" class="form-text text-muted">11 digits</small>
                </td >
	            </tr >
	            <tr >
		            <td >Name</td >
		            <td ><input class = "form-control form-control-sm mt-1 mb-1" form ="add_person" type = "text" name = "person[]" required></td >
	            </tr >
	            <tr >
		            <td >Surname</td >
		            <td ><input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required></td >
              </tr >   
                    <?php $controller->addPerson($_GET['person']); ?>
	            <tr >
		            <td >Gender</td >
		            <td >
                  <select class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                  </select>
                </td >
	            </tr >
	            <tr >
		            <td >Telephone</td >
		            <td >
                  <input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required>
                  <small id="telephone" class="form-text text-muted">Format: +xx xxx-xxx-xx</small>
                </td >
              </tr >
              <tr >
		            <td >Birth date</td >
		            <td >
                <input autocomplete="off" name = "person[]" form ="add_person"  class="form-control" type="text" id="birth_date" required>      
                </td >
	            </tr >
	            <tr >
		            <td >E-mail</td >
		          <td ><input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required></td >
	            </tr >
	            <tr >
		            <td >City</td >
		            <td ><input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required></td >
	            </tr >
	            <tr >
		            <td >Post code</td >
		            <td ><input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required></td >
	              </tr >
	            <tr >
		            <td >Street</td >
		            <td ><input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required></td >
	            </tr >
	            <tr >
		            <td >House nr</td >
		            <td ><input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "text" name = "person[]" required></td >
              </tr >
                <input class = "form-control form-control-sm mt-1 mb-1" form ="add_person"  type = "hidden" name = "person[]" value = "123" required>
	            <tr >
		            <td colspan = 2 ><button form ="add_person" class = "button"  type = "submit" >Add</buton></td >
	            </tr >
            </table >
          </div>
        </div>
      </div>
    <!--end of second main col -->
  </div>
</div>
<!--end main -->


<!-- Footer -->
<?php include './div/footer.html'?>
<script src = "js/datepicker.js"></script>
<!-- Footer -->
</body>
</html>
