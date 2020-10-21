<?php 
session_start(); 
include 'functions/class.school.php';

$teacher = new School;
$teacher->saveTeacher()
		->isSuccess()
		->getErrors();


?>

<!--			 FORMS ACTION HTML -->
<!-- SAVE -->
<form id = "save" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" ></form >
<form id = "back" action = "teachers_overview.php"></form >