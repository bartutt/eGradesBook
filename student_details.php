<?php session_start(); include 'functions/year.php';include 'functions/s_list.php';?>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title><?php include 'const_items/title.html'?></title>
</head>
<body onload="loadScroll()" onunload="saveScroll()">

<center>
<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>

<div class="header">Students overview<br> <?php echo $_POST['s_id'] ?></div>

<table class="main">
	<tr>
		<th style="width:20%">Nr</th><th>Name</th><th>Surname</th><th>Class</th>
	</tr>				
		<?php echo read_student_list();?>
</table>

<br><br>

<table class="bottom_buttons">
	<tr>
		
		
		
	</tr>
</table>


<?php include 'const_items/footer.html';?>
</center>


</body>
</html>


