<?php 
session_start(); 

include 'functions/class.school.php';
		

$display = new School();


switch($action){
    case 'delete': 			
        $delete = new School();
        $delete 
        ->deleteSubject($subject)
        ->isSuccess()
		->getErrors();
        break;   
    
    
    case 'add':	
        $add = new School();
        $add 
        ->saveSubject($subject)
        ->isSuccess()
		->getErrors();
        break;
}?>

<!--			 FORMS ACTION HTML -->
<!-- CREATE NEW SUBJECT -->
<form id = "subject" action = "<?php $_SERVER['PHP_SELF']?>" method = "post" >
    <input type = "hidden" name = "action" value = "add" >
</form >

<!-- GO BACK -->
<form id = "back" action = "index.php" ></form >


