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
    <div class = "header"><h2 class="display-4">Students</h2></div>
  </div>
  <!-- content -->
 
</div>
<!-- header -->


<!-- CONTROLLER -->
<?php
  $database = new DataBase();
  $controller = new Controller ($database);
  $student = new RandomPerson;

  $controller->htmlForm('add_student');
  

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
      <p class="lead">New student:</p>
        <table class = "table" >
          <tr >
		          <td >ID number</td >
		          <td ><input class = "form-control" form ="add_student"  type = "text" name = "student[]" value = "<?php echo rand(10000000000,99999999999); ?>" required></td >
	          </tr >
	          <tr >
		          <td >name</td >
		          <td ><input class = "form-control" form ="add_student" type = "text" value = "<?php echo $student->setName(); ?>" name = "student[]" required></td >
	          </tr >
	          <tr >
		          <td >surname</td >
		          <td ><input class = "form-control" form ="add_student"  type = "text" value = "<?php echo $student->setSurname();?>" name = "student[]" required></td >
            </tr >
            <input class = "form-control" form ="add_student" type = "hidden" value = "2" name = "student[]">
	          <tr >
		          <td >gender</td >
		          <td >
                <select class = "form-control" form ="add_student"  type = "text" name = "student[]" required>
                  <option>male</option>
                  <option>female</option>
                  <option>other</option>
                </select>
              </td >
	          </tr >
	          <tr >
		          <td >telephone</td >
		        <td ><input class = "form-control" form ="add_student"  type = "text" name = "student[]" value =" <?php echo '+47 ' . rand(100,999) . '-' . rand(100,999). '-' .rand(10,99) ?> " required></td >
            </tr >
            <tr >
		          <td >birth date</td >
		        <td >
            <input class = "form-control" form = "add_student" type="text" placeholder="yyyy-mm-dd" name = "student[]" required>       
            </td >
	          </tr >
	          <tr >
		          <td >e-mail</td >
		          <td ><input class = "form-control" form ="add_student"  type = "text" value = "<?php echo $student->setEmail();?>" name = "student[]" required></td >
	          </tr >
	          <tr >
		          <td >city</td >
		          <td ><input class = "form-control" form ="add_student"  type = "text" value = "<?php echo $student->setCity();?>" name = "student[]" required></td >
	          </tr >
	          <tr >
		          <td >post code</td >
		          <td ><input class = "form-control" form ="add_student"  type = "text" name = "student[]" value = "<?php echo rand(1000,9999)?>" required></td >
	            </tr >
	          <tr >
		          <td >street</td >
		          <td ><input class = "form-control" form ="add_student"  type = "text" value = "<?php echo $student->setStreet();?>" name = "student[]" required></td >
	          </tr >
	          <tr >
		          <td >house nr</td >
		          <td ><input class = "form-control" form ="add_student"  type = "text" name = "student[]" value = "<?php echo rand(0,999)?>" required><?php rand(0,999)?></td >
            </tr >
            <input class = "form-control" form ="add_student"  type = "hidden" name = "student[]" value = "123" required>
	          <tr >
		          <td colspan = 2 ><button form ="add_student" class = "button"  type = "submit" >Add new student</buton></td >
	          </tr >
        </table >
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
