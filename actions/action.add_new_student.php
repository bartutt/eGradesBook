<?php 
session_start(); 
include 'functions/class.school.php';

$student = new School;
$student->saveStudent()
		->isSuccess()
		->getErrors();


?>

<!--			 FORMS ACTION HTML -->
<!-- SAVE -->
<form id = "save" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" ></form >
