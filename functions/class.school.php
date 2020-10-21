<?php 
include './functions/class.database.php';
include './functions/class.random_person.php';

if ( isset ($_POST ['c_name']) )
		$class_name = $_POST['c_name'];
	else $class_name = "";

if ( isset ($_POST ['s_id'  ]) ) 
		 $student_id = $_POST['s_id'];
	else $student_id = "";

if ( isset ($_POST ['action']) )
		 $action = $_POST['action'];
	else $action = "";
	
if ( isset ($_POST ['teacher_id']) )
		 $teacher_id = $_POST['teacher_id'];
	else $teacher_id = "";	

if ( isset ($_POST ['profile']) )
		 $profile = $_POST['profile'];
	else $profile = "";	

if ( isset ($_POST ['class_sort']) )
		 $class_sort = $_POST['class_sort'];
	else $class_sort = "";	

if ( isset ($_POST ['sort_students']) )
		 $sort_students = $_POST['sort_students'];
	else $sort_students = "";	

if ( isset ($_POST ['sort_teachers']) )
		$sort_teachers = $_POST['sort_teachers'];
else 	$sort_teachers = "";

if ( isset ($_POST ['sort_students_in_class']) )
		 $sort_students_in_class = $_POST['sort_students_in_class'];
	else $sort_students_in_class = "";

if ( isset ($_POST ['status']) )
		 $status = $_POST['status'];
	else $status = "";

if ( isset ($_POST ['subject']) )
		$subject = $_POST['subject'];
	else $subject = "";

if ( !isset ($_SESSION['class_sorted'])) 
		$_SESSION['class_sorted'] = "";

if ( !isset ($_SESSION['sorted_st_class'])) 
		$_SESSION['sorted_st_class'] = "";

if ( !isset ($_SESSION['sorted_st_all']))
		$_SESSION['sorted_st_all'] = "";

if ( !isset ($_SESSION['teachers_sorted']))
		$_SESSION['teachers_sorted'] = "";


class School{

use DataBase;
use RandomPerson;



}//END OF CLASS


?>