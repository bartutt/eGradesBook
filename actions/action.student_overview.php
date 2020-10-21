<?php 
session_start(); 

include 'functions/class.school.php';

$display = new School();


?>
<!-- SORT BY CLASS - ALL STUDENTS -->
<form id="sort_by_class" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" name = "sort_students" value = "1" >		
</form >

<!-- SORT BY NAME - ALL STUDENTS-->
<form id="sort_by_name" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" name = "sort_students" value = "2" >	
</form >

<!-- SORT BY SURNAME - ALL STUDENTS-->
<form id="sort_by_surname" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" name = "sort_students" value = "3" >		
</form >

<!-- SORT BY ID - ALL STUDENTS-->
<form id="sort_by_id" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" name = "sort_students" value = "4" >	
</form >

<!-- SHOWS STUDENTS WITHOUT CLASS-->
<form id = "students_without_class" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "status" value = "noclass" >
</form >

<!-- SHOWS STUDENTS GRADUATES-->
<form id = "students_graduates" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "status" value = "graduate" >
</form >

<!-- SHOWS ALL STUDENTS-->
<form id = "students_all" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "status" value = "all" >
</form >

<!-- ADD NEW STUDENT-->
<form id = "add_new_student" action = "add_new_student.php"></form >

<!-- BACK TO INDEX-->
<form id = "back" action = "index.php" ></form >
