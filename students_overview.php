<?php include 'actions/action.student_overview.php'?>
<?php include 'js/reload.js'?>
<html >
<head >
	<link rel = "stylesheet" href = "style.css" >
	<title ><?php include 'const_items/title.html'?></title >
</head >
<body onload="loadScroll()" onunload="saveScroll()">

<center >
<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>

<div class = "header" >Students overview<br > <?php $display->displayYear() ?></div >

<table class = "bottom_buttons" >
	<tr >
		<td ><button class = "button" form = "add_new_student" >Add new student</button></td >	
		<td ><button class = "button" form = "students_without_class">show students without class</button></td >	
		<td ><button class = "button" form = "students_graduates" >show graduates</button></td >	
		<td ><button class = "button" form = "students_all">show all students</button></td >	
	</tr >
</table >

<table class = "main" >
	<tr >
			<td><button class = "button_arrow" form = "sort_by_id"> &#8595 sort by id </button></td >		
			<td><button class = "button_arrow" form = "sort_by_name"> &#8595 sort by name </button></td >
			<td><button class = "button_arrow" form = "sort_by_surname">&#8595 sort by surname </button></td >
			<td><button class = "button_arrow" form = "sort_by_class"> &#8595 sort by class </button></td >
	</tr >
	<tr >
		<th width = "20" >ID</th ><th >Name</th ><th >Surname</th ><th >Class</th ><th width = "50" >Action</th >
	</tr >				
		<?php $display->displayAllStudents($class_name, "details", "student_details.php", $sort_students, $status); ?>
</table >


<table class = "bottom_buttons" >
	<tr >
		<td><button class = "button" form = "back"> &larr; admin</button></td >	
	</tr >
</table >


<?php include 'const_items/footer.html';?>
</center >


</body >
</html >


