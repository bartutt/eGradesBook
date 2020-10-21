<?php 
session_start(); 

include 'functions/class.school.php';

$display = new School()

?>
<!-- 		FORMS ACTIONS IN HTML 		-->

<!-- ADD NEW TEACHER -->
<form id = "add_new_teacher" action = "add_new_teacher.php" method = "post" ></form >

<!-- SORT  TEACHERS-->
<form id="sort_by_name" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" name = "sort_teachers" value = "sort_by_name" >		
</form >

<!-- SORT  TEACHERS-->
<form id="sort_by_surname" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" name = "sort_teachers" value = "sort_by_surname" >	
</form >

<!-- BACK TO INDEX-->
<form id = "back" action = "index.php" ></form >