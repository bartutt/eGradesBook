<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.controller.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.displayer.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";

  
  $database = new DataBase();
  $displayer = new Displayer ($database);
  
  $login = new Logger($database,  $displayer);
  $login->isLogged($_SESSION['role'], 'index.php');

  $controller = new Controller ($database, $displayer, $login);

  $controller->htmlForm('change_pass');
  $controller->redirect('password1', 'password2', 'password3');
  
?>

<head>
  <title>eGradesBook - by BW</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--Bootstrap-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!--Bootstrap-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>



<body>
<div class = "container col-11 col-sm-6 mt-5 p-3 shadow">
<?php 
    echo $controller->getForms();
    $displayer->displayResult();
?>
<div class="form-group">
    <label for="password">Old password</label>
    <input form = "change_pass" name = "password1" type="password" class="form-control" id="password" placeholder="Old password">
  </div>
  <div class="form-group">
    <label for="password1">New password</label>
    <input form = "change_pass" name = "password2" type="password" class="form-control" id="password2" placeholder="New assword">
  </div>
  <div class="form-group">
    <label for="password2">New password</label>
    <input form = "change_pass" name = "password3" type="password" class="form-control" id="password3" placeholder="Repeat new password">
  </div>
  <div class = "text-right">
    <button form = "change_pass" type="submit" class="btn btn-success">Change</button>
    <a href = " <?php echo $_SESSION['role'];?>/index.php" class="btn btn-success">Finish</a>
  </div>

<div>
</body>
</html>
