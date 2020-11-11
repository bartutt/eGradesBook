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
        <div class = "col m-3 modul rounded shadow-sm">
          <div class = "header">
            <h2 class="display-4">Add person</h2>
          </div>


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
    <!--end of second main col -->
  </div>
</div>
<!--end main -->


<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->
</body>
</html>
