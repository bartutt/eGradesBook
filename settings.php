<?php 

  session_start();
  require_once './functions/class.school.php';

?>

<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>
<!-- head -->
<body>


<!-- topnav -->
<?php include './div/admin_topnav.html'?>
<!-- topnav -->



<!-- header -->
<div class="container" style="margin-top:30px">
   
<!-- content -->
  <div class="row">
    <div class = "header"><h2>School years</h2></div>
  </div>
  <div class="row">
    <p>Here you can add new year to DB list.</p>
  </div>
<!-- content -->
 
</div>
<!-- header -->





<!-- FORMS  -->
<form id = "add" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "action" value = "add">
</form >




<!-- main content -->
<div class="container" style="margin-top:30px">
  <div class="form-group">
    <label for="schoolYear">Enter a school year</label>
    <input  type = "text" class="form-control" name = "year" form ="add" placeholder="2020/2021" required>
  </div>
  <div class="form-group"> 
    <button class="button" form = "add" >add</button>
  </div>
  <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>years</th>
            </tr>
          </thead>
          <tbody>
              <?php 
              $display_years = new School(); 
              $display_years->display();
              ?>
          </tbody>
        </table>
</div>
<!-- main content -->



<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->


</body>
</html>
