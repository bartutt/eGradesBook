<?php 
session_start(); 

include 'functions/class.school.php';

$display = new School();
switch($action){
			case 'create': 	
				$create = new School();		
				$create	->createClass($class_name)
						->isSuccess()
						->getErrors();
						break;		
			
			
			case 'delete': 
				$delete = new School();							
				$delete ->deleteClass($class_name)
						->isSuccess()
						->getErrors();
						break;
}

?>
<!-- 		FORMS ACTIONS IN HTML 		-->

<!-- CREATE NEW CLASS -->
<form id = "create" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >		
		<input type = "hidden" name = "action" value = "create" >
</form >

<!-- SORT CLASSES UP -->
<form id="sort1" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" name = "class_sort" value = "1" >		
</form >

<!-- SORT CLASSES DOWN -->
<form id="sort2" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >	
		<input type = "hidden" name = "class_sort" value = "2" >	
</form >

<!-- BACK TO INDEX-->
<form id = "back" action = "index.php" ></form >