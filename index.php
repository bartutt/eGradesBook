<!DOCTYPE html>
<html lang="en">
<title>Sinmple design</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>
<?php 

if (isset ($_GET['msg']) && $_GET['msg'] === 'error' )
    echo 'Wrong user id/password';
?>
  <form action="login.php" method="post"> 
    <input type="text" name="login" /> 
    <br/> 
    <input type="password" name="password" /> 
    <br/>
    <button type="submit">log in</button>
  </form>

</body>
</html>
