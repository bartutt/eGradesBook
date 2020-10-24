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
    <div class = "header"><h2>Settings</h2></div>
  </div>
  <div class="row">
    <p>Here you can add new year, change lesson times, manage person status, marks categories or change current year.</p>
  </div>
<!-- content -->
 
</div>
<!-- header -->


<!-- PHP BACKEND SECTION -->
<?php 
if (!empty ($_POST) )
	switch ( $_POST['action'] ){

	case 'add':
		$add_year = new School;
		$add_year->addYear($_POST['year'])->isSuccess()->getErrors();
		break;

}
?>

<!-- FORM  -->
<form id = "add" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "action" value = "add">
</form >

<!-- PHP BACKEND SECTION -->





<!-- main content -->
<div class="container" style="margin-top:30px">
<!-- header content -->
<div class="row">
    <div class = "header-content"><h5>Year manage</h5></div>
</div>
<!-- header content -->



<!-- years management -->

  <div class="form-group">
    <label for="schoolYear">Add new year</label>
    <input  type = "text" class="form-control" name = "year" form ="add" placeholder="2020/2021" required>
  </div>
  <div class="form-group"> 
    <button class="button" form = "add" >add</button>
  </div>
 

 <!-- modal windows shows years -->
<button type="button" class="button" data-toggle="modal" data-target=".years">Show years</button>
<div class="modal fade years" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Years</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
        
      <div class="modal-body">
        <table class="table table-striped table-sm">
          <tbody>
              <?php $display_years = new School; $display_years->displayYears();?>
          </tbody>
        </table>      
      </div>
    </div>
  </div>
</div>
        


<div class="form-group">
    <label for="schoolYear">Set current year</label>
    <select id = "schoolYear" class = "form-control" form = "select" name = "year" >
      <?php $display_years = new School; $display_years->displayYearsSelect();?>
    </select>

  </div>
  <div class="form-group">
    <button class="button" form = "select" >set</button>
</div>
<!-- years management -->


</div>
<!-- main content -->



<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->


</body>
</html>
