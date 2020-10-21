<?php include 'actions/action.subjects_overview.php';?>
<?php include 'js/reload.js'?>


<html  >
<head  >
	<link rel  =  "stylesheet" href  =  "style.css"  >
	<title  ><?php include 'const_items/title.html'?></title  >
</head  >
<body onload  =  "loadScroll()" onunload  =  "saveScroll()"  >

<center  >
<?php include 'const_items/topnav_admin.html'; include 'const_items/logo_text.html';?>

<div class  =  "header"  >Add new subject</div  >

<table class = "bottom_buttons" >
	<tr >
		<td >Subject name</td >
	</tr >
	<tr >
		<td ><input form  =  "subject" type  =  "text" name = "subject" ></td >
		<td ><button form  =  "subject" class = "button" type = "submit" >Add new subject</button ></td >
	</tr >
</table >
<div class  =  "header"  >Subjects overview <?php $display->displayYear(); ?></div >
<table class  =  "main" >
	<tr >
		<th >Subject</th ><th width = "50">Action</th >
	</tr >				
		<?php $display->displaySubjects(); ?>
</table >
<p>*Note: You can't delete subject completely before this school year is finished.</p>
<table class  =  "bottom_buttons" >
	<tr >
		<td><button form  =  "back" class  =  "button" form  =  "back"> &larr; admin</button></td >	
	</tr >
</table >


<?php include 'const_items/footer.html';?>
</center >


</body >
</html >


