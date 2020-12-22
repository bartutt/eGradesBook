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
if (isset ($_GET['msg']) && $_GET['msg'] === 'error' )
    echo 'Wrong user id/password';
?>
<form action="login.php" method="post">
  <div class="form-group">
    <label for="ID">ID</label>
    <input name = "login" type="text" class="form-control" id="ID" placeholder="Enter ID">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input name = "password" type="password" class="form-control" id="password" placeholder="Password">
  </div>
  <div class = "text-right">
    <button type="submit" class="btn btn-success">Log in</button>
  </div>
</form>

<div>
</body>
</html>
