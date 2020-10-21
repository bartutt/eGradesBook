<?php 
include 'actions/action.add_new_teacher.php';
include 'js/reload.js'
?>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<title><?php include 'const_items/title.html'?></title>
</head>
<body onload="loadScroll()" onunload="saveScroll()">

<center>
<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>

<div class="header">Add new teacher</div>

<table class="main">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<tr >
		<td >Name</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $teacher->setName(); ?>" name = "name" required></td >
	</tr >
	<tr >
		<td >Surname</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $teacher->setSurname();?>" name = "surname" required></td >
	</tr >
	<tr >
		<td >ID number</td >
		<td ><input form ="save"  type = "text" name = "id" value = "<?php echo rand(100000,999999); ?>" required></td >
	</tr >
	<tr >
		<td >Subject 1 - optional</td >
		<td ><select form = "save" name = "subject_1" ><option value = "-">-----</option> <?php $teacher->displaySubjectsForm()?></select></td >
	</tr >
	<tr >
		<td >Subject 2 - optional</td >
		<td ><select form = "save" name = "subject_2" required><option value = "-">-----</option><?php $teacher->displaySubjectsForm()?></select></td >
	</tr >
	<tr >
		<td >Subject 3 - optional</td >
		<td ><select form = "save" name = "subject_3" required><option value = "-">-----</option><?php $teacher->displaySubjectsForm()?></select></td >
	</tr >
	<tr >
		<td >Telephone</td >
		<td ><input form ="save"  type = "text" name = "tel" value = "<?php echo rand(100,999) . "-" . rand(100,999). "-" .rand(10,99) ?>" required></td >
	</tr >
	<tr >
		<td >E-mail</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $teacher->setEmail();?>" name = "email" required></td >
	</tr >
	<tr >
		<td >City</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $teacher->setCity();?>" name = "city" required></td >
	</tr >
	<tr >
		<td >Post code</td >
		<td ><input form ="save"  type = "text" name = "code" value = "<?php echo rand(1000,9999)?>" required></td >
	</tr >
	<tr >
		<td >Street</td >
		<td ><input form ="save"  type = "text" value = "<?php echo $teacher->setStreet();?>" name = "street" required></td >
	</tr >
	<tr >
		<td >House nr</td >
		<td ><input form ="save"  type = "text" name = "housenr" value = "<?php echo rand(0,999)?>" required><?php rand(0,999)?></td >
	</tr >
	<tr >
		<td colspan = 2 ><button form ="save" class = "button"  type = "submit" >Add new teacher</buton></td >
	</tr >
</table>


<table class = "bottom_buttons" >
	<tr >
		<td><button class = "button" form = "back"> &larr; teacher overview</button></td >	
	</tr >
</table >




<?php include 'const_items/footer.html';?>
</center>
</body>
</html>


