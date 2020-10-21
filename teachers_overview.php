<?php include 'actions/action.teachers_overview.php';?>
<?php include 'js/reload.js'?>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<title><?php include 'const_items/title.html'?></title>
</head>
<body onload="loadScroll()" onunload="saveScroll()">

<center>
<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>
<div class="header">Teachers overview<br> <?php $display->displayYear() ?></div>
<table class = "bottom_buttons" >
	<tr >
		<td ><button class = "button" form = "add_new_teacher" >Add new teacher</button></td >		
	</tr >
</table >
<table class="main">
	<tr >
			<td></td >		
			<td><button class = "button_arrow" form = "sort_by_name"> &#8595 sort by name </button></td >
			<td><button class = "button_arrow" form = "sort_by_surname">&#8595 sort by surname </button></td >
	</tr >
	<tr>
		<th width="20">Nr</th><th>Name</th><th>Surname</th><th>Subject 1</th><th>Subject 2</th><th>Subject 3</th><th width = "50" >Action</th ><th width = "50" ></th >
	</tr>
		<?php $display->displayTeachers($sort_teachers);?>	 
</table>

<table class = "bottom_buttons" >
	<tr >
		<td><button class = "button" form = "back"> &larr; admin</button></td >	
	</tr >
</table >


<?php include 'const_items/footer.html';?>
</center>


</body>
</html>


