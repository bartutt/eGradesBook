<?php include 'actions/action.class_edit.php'?>
<?php include 'js/reload.js'?>
<html >
<head >
	<link rel = "stylesheet" href = "style.css" >
	<title ><?php include 'const_items/title.html'?></title >
	
</head >
<body onload="loadScroll()" onunload="saveScroll()">

<center >

<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>

<table class = "bottom_buttons" >
	<tr >
		<td >Change a class teacher</td >
		<td ><select form = "change_teacher" name = "teacher_id" ><?php $display-> displayTeachersForm();?></select ></td >	
		<td ><button form = "change_teacher" class = "button_details">Change teacher</button></td >
		<td >Change a profile</td >
		<td ><select form = "change_profile" name = "profile" ><?php $display-> displayProfilesForm();?></select ></td >	
		<td ><button form = "change_profile" class = "button_details" >Change profile</button></td >
	</tr >	
</table >

<div class = "header" >
<?php echo "Class: " .$class_name."<br >Profile: "; echo $display->displayProfile($class_name)."<br >Main teacher: ";echo $display->displayTeacher($class_name);?></div >


<table class = "main" >	
	<tr>
			<td></td>
			<td><button class="button_arrow" form = "class_sort_by_name"> &#8595 sort by name </button></td >
			<td><button class="button_arrow" form = "class_sort_by_surname"> &#8595 sort by surname </button></td >
	</tr >
	<tr >
		<th width = "20" >Nr</th ><th >Name</th ><th >Surname</th ><th width = "50" >Action</th >	
	</tr >
		<?php $display->displayStudentsClass($class_name,"delete", $_SERVER['PHP_SELF'], $sort_students_in_class);?>
</table >



<table class = "bottom_buttons" >
	<tr >
		<td ><button class = "button" form = "students_without_class">show students without class</button></td >	
		<td ><button class = "button" form = "students_graduates" >show graduates</button></td >	
		<td ><button class = "button" form = "students_all">show all students</button></td >	
	</tr >
</table >

<table class = "main" >
	<tr >
			<td><button class="button_arrow" form = "sort_by_id"> &#8595 sort by id </button></td >		
			<td><button class="button_arrow" form = "sort_by_name"> &#8595 sort by name </button></td >
			<td><button class="button_arrow" form = "sort_by_surname"> &#8595 sort by surname </button></td >
			<td><button class="button_arrow" form = "sort_by_class"> &#8595 sort by class </button></td >
	</tr >
	<tr >
		<th width = "20" >ID</th ><th >Name</th ><th >Surname</th ><th >Class</th ><th width = "50px" >Action</th >
	</tr >
		<?php $display->displayAllStudents($class_name, "add" , $_SERVER['PHP_SELF'], $sort_students, $status);?>
</table >



<table class = "bottom_buttons" >
	<tr >
		<td><button class = "button" form = "back"> &larr; classes overview</button></td >	
	</tr >
</table >

<?php include 'const_items/footer.html';?>
</center >


</body >
</html >


