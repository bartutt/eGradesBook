<?php 
session_start(); 
include 'functions/class.school.php';;

$display = new School;
switch($action){
			case 'delete': 
				$delete = new School();			
				$delete
				->moveStudentOut($class_name, $student_id)			
				->isSuccess()
				->getErrors();
				break;
			
			case 'add': 
				$add = new School();			
				$add
				->moveStudentIn($class_name, $student_id)
				->isSuccess()
				->getErrors();;
				break;
	
			case 'change_teacher':	
				$change = new School();
				$change
				->changeTeacher($class_name,$teacher_id)
				->isSuccess()
				->getErrors();
				break;
			
			case 'change_profile':
				$change = new School();
				$change
				->changeProfile($class_name, $profile)
				->isSuccess()
				->getErrors();	
				break;
			}
?>

<!--			 FORMS ACTION HTML -->
<!-- CHANGE TEACHER -->
<form id = "change_teacher" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >		
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" value = "change_teacher" name = "action" >			
</form >

<!-- CHANGE PROFILE -->
<form id = "change_profile" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >		
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" value = "change_profile" name = "action" >				
</form >

<!-- SHOWS STUDENTS WITHOUT CLASS-->
<form id = "students_without_class" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "status" value = "noclass" >
	<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
</form >

<!-- SHOWS STUDENTS GRADUATES-->
<form id = "students_graduates" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "status" value = "graduate" >
	<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
</form >

<!-- SHOWS ALL STUDENTS-->
<form id = "students_all" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
	<input type = "hidden" name = "status" value = "all" >
	<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
</form >
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
<!-- SORT BY NAME - STUDENTS IN CLASS-->
<form id="class_sort_by_name" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" name = "sort_students_in_class" value = "1" >		
</form >

<!-- SORT BY SURNAME - STUDENTS IN CLASS-->
<form id="class_sort_by_surname" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" value = <?php echo $class_name?> name = "c_name" >
		<input type = "hidden" name = "sort_students_in_class" value = "2" >	
</form >

<!-- BACK TO CLASSES OVERVIEW-->
<form id = "back" action = "classes_overview.php" ></form >
