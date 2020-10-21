<?php include 'actions/action.classes_overview.php'?>
<?php include 'js/reload.js'?>
<html >
<head >
	<link rel = "stylesheet" href = "style.css" >
	<title ><?php include 'const_items/title.html'?></title >
</head >
<body onload="loadScroll()" onunload="saveScroll()">
<center >

<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>

<div class = "header" >Create new class</div >

<table class = "bottom_buttons" >
	<tr >
		<td >Class name</td >
	</tr >
		<td ><input form ="create" type = "text" name = "c_name" maxlength = 2 required></td >
		<td align="right" ><button class="button" form = "create" >create</button></td >
	</tr >
</table >

<div class = "header" >Classes overview <?php $display->displayYear() ?></div >

<table class = "main" >
	<tr >	
		<td >
			<button class="button_arrow" form = "sort1"> &#8595 </button>
			<button class="button_arrow" form = "sort2"> &#8593 </button>
		</td >		
	</tr >
	<tr >
		<th width = "20" >Cl</th ><th >Teacher</th ><th >Profile</th ><th >Students</th ><th width = "50" >Action</th ><th width = "50" ></th >
	</tr >				
		<?php $display->displayClasses($class_sort);?>
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


