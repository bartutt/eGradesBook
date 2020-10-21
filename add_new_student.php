<?php include 'actions/action.add_new_student.php'?>

<?php include 'js/reload.js'?>

<html >
<head >
<link rel = "stylesheet" href = "style.css" >
	<title ><?php include 'const_items/title.html'?></title >
	</head >
<body onload = "loadScroll()" onunload = "saveScroll()" >

<center >
<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>

<div class = "header" >Add new student</div >

<table class = "main" >
	<tr >
		<td >Name</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $student->setName(); ?>" name = "name" required></td >
	</tr >
	<tr >
		<td >Surname</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $student->setSurname();?>" name = "surname" required></td >
	</tr >
	<tr >
		<td >ID number</td >
		<td ><input form ="save"  type = "text" name = "id" value = "<?php echo rand(100000,999999); ?>" required></td >
	</tr >
	<tr >
		<td >ID number of child supervisor</td >
		<td ><input form ="save"  type = "text" value = "<?php echo rand(100000,999999)?>" name = "id_spr" required></td >
	</tr >
	<tr >
		<td >Telephone</td >
		<td ><input form ="save"  type = "text" name = "tel" value = "<?php echo rand(100,999) . "-" . rand(100,999). "-" .rand(10,99) ?>" required></td >
	</tr >
	<tr >
		<td >E-mail</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $student->setEmail();?>" name = "email" required></td >
	</tr >
	<tr >
		<td >City</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $student->setCity();?>" name = "city" required></td >
	</tr >
	<tr >
		<td >Post code</td >
		<td ><input form ="save"  type = "text" name = "code" value = "<?php echo rand(1000,9999)?>" required></td >
	</tr >
	<tr >
		<td >Street</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $student->setStreet();?>" name = "street" required></td >
	</tr >
	<tr >
		<td >House nr</td >
		<td ><input form ="save"  type = "text" name = "housenr" value = "<?php echo rand(0,999)?>" required><?php rand(0,999)?></td >
	</tr >
	<tr >
		<td colspan = 2 ><button form ="save" class = "button"  type = "submit" >Add new student</buton></td >
	</tr >
</table >





<form id = "back" action = "students_overview.php" ></form >
<table class = "bottom_buttons" >
	<tr >
		<td><button class = "button" form = "back"> &larr; students overview</button></td >	
	</tr >
</table >


<?php include 'const_items/footer.html';?>
</center >
</body >
</html >


