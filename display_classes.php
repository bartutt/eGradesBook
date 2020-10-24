<?php include './functions/class.school.php' ?>
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
  <div class="row">
  <!-- content -->
  <div class = "col">
    <div class = "header" ><h2>Classes</h2></div>
  </div>
  <!-- content -->
  
  <div class = "col-xl-4">
  <div class="form-group">
    <label for="schoolYear">Choose years</label>
    <select id = "schoolYear" class = "form-control" form = "select" name = "year" ><?php $display_years = new School; $display_years->displayYearsSelect();?></select>
    </div>
    <div class="form-group">
    <button class="button" form = "select" >select</button>

  </div>
  </div>
  </div>
</div>

<form id = "select" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" ></form >

<!-- header -->


<!-- main content -->
<div class="container" style="margin-top:30px">
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>class</th><th>teacher</th><th>profile</th><th>year</th><th>students</th>
            </tr>
          </thead>
          <tbody>
              <?php 
              $classes = new School; 
              if (empty ($_POST['year'])) 
                $_POST['year'] = "2020/2021";
              
              $classes->displayClasses($_POST['year']);
              ?>
          </tbody>
        </table>
  </div>
</div>
<!-- main content -->



<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->


</body>
</html>
