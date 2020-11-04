<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';
  require_once './functions/class.random_person.php';
  
  $database = new DataBase();
  $controller = new Controller ($database);
  $person = new RandomPerson;

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
    <div class = "header"><h2 class="display-4">Add person</h2></div>
  </div>
  <!-- content -->
 
</div>
<!-- header -->


<!-- CONTROLLER -->
<?php
  
  $controller->htmlForm('add_person');

  echo $controller->getForms();

  $displayer = new Displayer ($database);


  if (!empty ($_POST)){
    $controller->handleRequest ($_POST['action'], $_POST['old_value'], $_POST['person']);
    $displayer->displayErrors();
    $displayer->displaySuccess();
  }
?>
<!-- CONTROLLER -->


<!-- main content -->
<div class="container">
  <div class="row">
    <div class="col 12">
      <p class="lead">Fill up form:</p>
        <table class = "table" >
          <tr >
		          <td >ID number</td >
		          <td ><input class = "form-control" form ="add_person"  type = "text" name = "person[]" value = "<?php echo rand(10000000000,99999999999); ?>" required></td >
	          </tr >
	          <tr >
		          <td >name</td >
		          <td ><input class = "form-control" form ="add_person" type = "text" value = "<?php echo $person->setName(); ?>" name = "person[]" required></td >
	          </tr >
	          <tr >
		          <td >surname</td >
		          <td ><input class = "form-control" form ="add_person"  type = "text" value = "<?php echo $person->setSurname();?>" name = "person[]" required></td >
            </tr >
            <tr >
              <td >Set role/status</td >
              <td>
                <select class = "form-control" form ="add_person"  type = "text" name = "person[]" required>
                <?php $displayer->displayRoleStatusSelect(); ?>
                </select>
              </td >
            </tr >
	          <tr >
		          <td >gender</td >
		          <td >
                <select class = "form-control" form ="add_person"  type = "text" name = "person[]" required>
                  <option>male</option>
                  <option>female</option>
                  <option>other</option>
                </select>
              </td >
	          </tr >
	          <tr >
		          <td >telephone</td >
		        <td ><input class = "form-control" form ="add_person"  type = "text" name = "person[]" value ="<?php echo '+47 ' . rand(100,999) . '-' . rand(100,999). '-' .rand(10,99) ?> " required></td >
            </tr >
            <tr >
		          <td >birth date</td >
		        <td >
            <input class = "form-control" form = "add_person" type="text" placeholder="yyyy-mm-dd" name = "person[]" required>       
            </td >
	          </tr >
	          <tr >
		          <td >e-mail</td >
		          <td ><input class = "form-control" form ="add_person"  type = "text" value = "<?php echo $person->setEmail();?>" name = "person[]" required></td >
	          </tr >
	          <tr >
		          <td >city</td >
		          <td ><input class = "form-control" form ="add_person"  type = "text" value = "<?php echo $person->setCity();?>" name = "person[]" required></td >
	          </tr >
	          <tr >
		          <td >post code</td >
		          <td ><input class = "form-control" form ="add_person"  type = "text" name = "person[]" value = "<?php echo rand(1000,9999)?>" required></td >
	            </tr >
	          <tr >
		          <td >street</td >
		          <td ><input class = "form-control" form ="add_person"  type = "text" value = "<?php echo $person->setStreet();?>" name = "person[]" required></td >
	          </tr >
	          <tr >
		          <td >house nr</td >
		          <td ><input class = "form-control" form ="add_person"  type = "text" name = "person[]" value = "<?php echo rand(0,999)?>" required><?php rand(0,999)?></td >
            </tr >
            <input class = "form-control" form ="add_person"  type = "hidden" name = "person[]" value = "123" required>
	          <tr >
		          <td colspan = 2 ><button form ="add_person" class = "button"  type = "submit" >Add new person</buton></td >
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
