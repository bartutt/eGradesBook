<?php include 'actions/action.admin_dashboard.php'?>
<?php include 'js/reload.js'?>

<html>
<head>
<link rel="stylesheet" href="style.css">
<title><?php include 'const_items/title.html'?></title>
</head>
<body onload="loadScroll()" onunload="saveScroll()">

<center>
<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>
<div class="header">Admin profil<br><br>Year <?php $display->displayYear(); ?></div>



	<table class="bottom_buttons">
		<tr>
			<td><button class = "button" form = "start" type = "submit">Start new year!</td>
		</tr>
	</table>
		
<?php include 'const_items/footer.html';?>

	


</center>
</body>
</html>


