<?php

/**
* Database for school      
* 
* @author Bartlomiej Witkowski
* 
*
*
*
* @private $errors
* @private $succes
* @private $dir_content
*/


trait DataBase{

/**    
*	contain errors wchich came while processing
*
* @var array
*/    

public $errors = array();
    
/**    
*	contain information what was done
*
* @var array
*/ 
public $success = array();





/** 
*   
* Display errors
*
*/
public function getErrors(){

	foreach ($this->errors as $error) {
        echo '
        <div class = "container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Error</h4><hr>' . $error .
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </div>';
		}          
	return $this;

}
/** 
*      
* Display success if process went ok
*
*/           
public function isSuccess(){
	foreach ($this->success as $success) {
        echo '
        <div class = "container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Perfect!</h4><hr>' . $success .
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </div>';
	}                 
	return $this;
}


private function connectDB(){
    $server = "127.0.0.1";
    $user = "root";
    $pass = "";
    $dbname = "eschool";
    
    $this->conn = new mysqli($server, $user, $pass, $dbname);
    
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
}


public function createTableClasses(){
 //"ALTER TABLE classes ADD CONSTRAINT class_year UNIQUE (class_name, school_year)";
    $this->connectDB();

    $sql ="CREATE TABLE classes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        class_name VARCHAR(2) NOT NULL,
        teacher_id VARCHAR(30) NOT NULL,
        profile_id INT(5),
        school_year VARCHAR(8)
        )";
    
    if ($this->conn->query($sql) === TRUE) {
      echo "Table classes created successfully";
    } else {
      echo "Error creating table: " . $this->conn->error;
    }
    
    $this->conn->close();
}


public function createTableYears(){
    //"ALTER TABLE classes ADD CONSTRAINT class_year UNIQUE (class_name, school_year)";
       $this->connectDB();
   
       $sql ="CREATE TABLE years (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            school_year VARCHAR(9) NOT NULL,
            UNIQUE (school_year)
           )";
       
       if ($this->conn->query($sql) === TRUE) {
         $this->success[] = 'Table years created successfully';
       } else {
        $this->errors[] = 'Error creating table: ' . $this->conn->error;
       }
       
       $this->conn->close();

       return $this;
}


public function addClass($name, $year){

    $this->connectDB();
    
    $stmt = $this->conn->prepare("INSERT INTO classes (class_name, school_year) VALUES (?, ?)");
    
    $stmt->bind_param("ss", $class_name, $school_year);
    
    $class_name = $name;
    $school_year = $year;
    if ( $stmt->execute() )
        $this->success[] = $class_name . ' created successfully';       
    else    
        $this->errors[] = 'Something went wrong';
    
        $stmt->close();
        $this->conn->close();
  
    return $this;
}


public function addYear($year) {

    $this->checkYear($year);

    if (empty ($this->errors)) {
        $this->connectDB();
    
        $stmt = $this->conn->prepare("INSERT INTO years (school_year) VALUES (?)");
    
        $stmt->bind_param("s", $school_year);
    
        $school_year = $year;
        if ( $stmt->execute() )
            $this->success[] = $school_year . ' is added successfully';       
        else    
            $this->errors[] = 'Something went wrong';
    
            $stmt->close();
            $this->conn->close();
    } 
    
    return $this;

}


public function displayClasses($year){

    $this->connectDB();

    $sql = "SELECT * FROM classes where school_year = '$year' ";

    $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                 echo 
                    "<tr>          
                        <td>" . $row['class_name'] . "</td>                         
                        <td>".  $row['teacher_id']. "</td>
                        <td>".  $row['profile_id']. "</td>
                        <td>" . $row['school_year'] . "</td>
                        <td>" . $row['profile_id'] . "</td>
                    </tr>";
                }
        }else 
            $this->errors[] = '0 results';

}


public function displayYears(){

    $this->connectDB();

    $sql = "SELECT * FROM years";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
             echo 
                "<tr>          
                    <td>" . $row['school_year'] . "</td>                         
                </tr>";
            }
    }else 
        $this->error[] = '0 results';

}


public function displayYearsSelect(){

    $this->connectDB();

    $sql = "SELECT * FROM years";

    $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                 echo 
                    '<option value = ' . $row['school_year'] .'>'         
                         . $row['school_year'] .                       
                    '</option>';
                }
        }else 
            $this->error[] = '0 results';

}










#######################################################
#######################################################
#######################################################
/**    
*	this properties contain information sent via form
*
* 
*/  
private $name; 
private $surname;
private $id;
private $id_supervisor; 
private $tel;
private $email; 
private $city; 
private $code; 
private $street;
private $housenr;








/**    
*	contain array with files form current directory
*
* @var array
*/    
private $dir_content = array();
    

/** 
*   
* This function removes whitespaces, dangerous chars etc..
*
*/
private function inputTrim($input){
        
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
    return $input;
}







/*
*
* This function read a directory into array
*
* @param $path - path to folder which will be read into array
*/  
protected function setDirToArray($path){
	$this->dir_content = array_diff (scandir ($path , 1),  array ('.', '..',));

	return $this;

}

/*
*
* Read and display current year
* 
* 
*/  
public function displayYear(){

    echo file_get_contents ('./db/year.txt');

}

/*
*
* This function reads teacher DB directory into array
* and display teachers as a "select" form
* 
*/ 
public function displayTeachersForm(){
	
    $this->setDirToArray('./db/t_db/');
    
    $count = count ($this->dir_content) -1;
    for ($i = 0; $i <= $count - 1; $i++){					
        $t_id = substr ($this->dir_content[$i], 0, -4);    
        
        $teacher = file ('./db/t_db/'. $this->dir_content[$i] );
            
            echo '<option value = ' . $t_id . '>' . $teacher[1] . ' ' . $teacher[2].'</option>';
        }		
}

/*
*
* This function reads profiles from profiles DB
* and display as a 'select' form
* 
*/ 
public function displayProfilesForm(){
		
    $profiles = file ('./db/profiles.txt');
    $count = count ($profiles) -1;
    
    for ($i = 0; $i <= $count; $i++){
                        
            echo '<option value = ' . $profiles[$i] . '>' . $profiles[$i] .'</option>';
        
        }		
}

/*
*
* This function subjects from subject DB
* and display as a 'select' form
* 
*/ 
public function displaySubjectsForm(){
		
    $subjects = file ('./db/subjects.txt');
    $count = count ($subjects) -1;
    
    for ($i = 0; $i <= $count; $i++){
                        
            echo '<option value = ' . $i . '>' . $subjects[$i] .'</option>';
        
        }		
}





/**
* Display profile      
* 
* This function display profile from current class
* Read profile name directly from class file
* 
* 
*
* @param $class_name - ..
*
*/
public function displayProfile($class_name){

    $class_content = array_reverse (file ('./db/c_db/' . $class_name . '.txt') );
        
        // returns profile name
        return $class_content[0];	


}

/**
* Display teacher      
* 
* This function display teacher details
* Read classID.txt into array, find teacher ID
* Read teacher details by ID from teachers DB
* 
* If teacher does not exist then display NoTeacher
*
* @param $class_name - ..
*/
public function displayTeacher($class_name){
            
    $class_content = array_reverse ( file ('./db/c_db/' . $class_name . '.txt') );
        
        $teacherID = trim ($class_content[1] );
    
    // if file no exist then display NoTeacher
    if (!file_exists ('./db/t_db/' .  $teacherID . '.txt') )
        return "NoTeacher";

    else{
        
        $teacher_details =  file ('./db/t_db/' . $teacherID . '.txt');
        
            list ($subject, $name, $surname) = $teacher_details;
        
        
        return $name . ' ' . $surname;
    }
}


/**
* Display subjects    
* 
* This function reads subjects into array 
* and display in table form 
*
*/
public function displaySubjects(){
    
    $subject = file ('./db/subjects.txt');
	
    $subjects_qty = count($subject) - 1;
		for ($i = 0; $i <= $subjects_qty; $i++){     
            echo "<tr>
					<form action = subjects_overview.php method = post >
						<td>". $subject[$i] ."</td>
						<input type = hidden  value = '$subject[$i]'  name = 'subject'>
						<input type = hidden value = 'delete' name = 'action'>
						<td><input type = 'submit' class = 'button_details' value = delete> </td>
					</form >
				</tr>";}
	}


/**
* Display classes      
* 
* This function display teacher list
* 
*/
public function displayTeachers ($sort){
       
    $this->setDirToArray ("./db/t_db/");
    
    $teachers_list = $this->dir_content;

    $teachers_qty = count($teachers_list) -1;
    
        
    
        $count = count ($this->dir_content) -1;
    
        for ($i = 0; $i <= $teachers_qty; $i++){

            $subjects = file ("./db/subjects.txt");
            
            $teachers_list[$i] = substr ($teachers_list[$i], 0, -4);	                
            
            $teacher_details = file ('./db/t_db/' . $teachers_list[$i] .'.txt' );
            $teacher_subjects = explode ('|', file_get_contents ('./db/t_db/' . $teachers_list[$i] .'.txt' ));

            $name[$i] = $teacher_details[1];
            $surname[$i] = $teacher_details[2];
            $t_id[$i] = $teachers_list[$i];

                if ($teacher_subjects[0] !== '-')    
                    $subject_1[$i] = $subjects [ $teacher_subjects[0] ];
                else 
                    $subject_1[$i] = 'none';
            
                if ($teacher_subjects[1] !== '-')                 
                    $subject_2[$i] = $subjects [ $teacher_subjects[1] ];
                else 
                    $subject_2[$i] = 'none';    
            
                if ($teacher_subjects[2] !== '-')                  
                    $subject_3[$i] = $subjects [ $teacher_subjects[2] ];
                else 
                    $subject_3[$i] = 'none';                      
            
        }
        
        if (!empty ($sort) ) 
            $_SESSION['teachers_sorted'] = $sort;
        
        switch($_SESSION['teachers_sorted']) {
            case 'sort_by_name': array_multisort($name, $surname, $t_id);break;
            case 'sort_by_surname': array_multisort($surname, $name, $t_id);break;
        }


        for ($i = 0; $i <= $teachers_qty; $i++) {
                echo "						
                        <tr>
                            <td>" . ($i +1). "</td>                         
                            <td>".  $name[$i]. "</td>
                            <td>".  $surname[$i]. "</td>
                            <td>" . $subject_1[$i] . "</td>
                            <td>" . $subject_2[$i] . "</td>
                            <td>" . $subject_3[$i] . "</td>
                               
                                <form action = class_edit.php method = post>
                                <input name = c_name type = hidden value = >								
                            
                             <td><input class = button_details type = submit value = details></td>	
                                </form>
                                
                                <form action = classes_overview.php method = post>
                                <input name = c_name type = hidden value = >
                                <input name = action type = hidden value = delete>
                           
                            <td><input class = button_details type = submit value = delete></td>
                                </form>							
                        </tr>";
        }
}	



/**
* Display students in current class      
* 
* This function reads a classID.txt (i.e 1a) into array 
* count students and read all students into new arrays - name, surname and ID
*  
* Session variables holds current type of sorting, if sorting is not set then is default
* 2 types of sorting, by NAME nad SURNAME
*
* Last loop displays students in table 
*
*
* @param $class - name of class
* @param $value - value of hidden form parameter to control 'switch' in actions
* @param $action - where site will redirected after submit
* @param $sort - type of sorting
*
*/
public function displayStudentsClass($class, $value, $action, $sort){	
    
   $student_id = file ('./db/c_db/'. $class . '.txt');
    
   // -3 because of teacher line and profile line
   $students_qty = count ($student_id) - 3;
 
        for($i = 0; $i <= $students_qty; $i++) {
            
            $student_id[$i] = trim ($student_id[$i] );
            
            $student_details = file ('./db/s_db/' . $student_id[$i] .'/data.txt' ) ;
                $name[$i] = trim ($student_details[1] ) ;
                $surname[$i] = $student_details[2];
                $s_id[$i] = $student_id[$i];
        }
    
    if (!empty ($sort) ) 
        $_SESSION['sorted_st_class'] = $sort;
    

    if (isset ($name) && isset ($surname) && isset ($s_id))
        switch($_SESSION['sorted_st_class']) {
            case '1':	array_multisort($name, $surname, $s_id);break;
            case '2':	array_multisort($surname, $name, $s_id);break;	
        }
    
       
    for ($i = 0; $i<=$students_qty; $i++) {	
                echo "
                    <tr>
                        <td>" . ($i + 1) . "</td>
                        <td>" . $name[$i] . "</td>
                        <td>" . $surname[$i] . "</td>
                        <form action = $action method = post>
                        <input name = s_id type = hidden value = $s_id[$i] >
                        <input type = hidden value = $class name = c_name>
                        <input type = hidden value = $value name = action>
                        <td><input class = button_details type = submit value = $value></td>			
                        </form>
                    </tr>";
    }
}	


/**
* Display all students      
* 
* This function reads all student from s_db
* count them and read into new arrays - class, name, surname and ID
*
* Session varaible holds status of last sorting
* If sorting not set, then is default
*
* 4 types of sorting, by CLASS, NAME, SURMAME and ID
*
* Last 3 loops shows: all students, graduate students and students without class
*
* @param $current_class - name of current class
* @param $value - value of hidden form parameter to control 'switch' in actions
* @param $action - where site will redirected after submit
* @param $sort - type of sorting
* @param $status - class status i.e 0 - NoClass, 1b, or 2 - graduate
*
*/
public function displayAllStudents($current_class, $value, $action, $sort, $status) {
     
    $this->setDirToArray("./db/s_db/");
    
    $student_id = $this->dir_content;
    $students_qty = count ($student_id) -1;
    
    // type of sorting 0 - all students, 1 - graduates students, 2 - NoClass students
    if (!isset ($_SESSION ['sort_count'] ) ) 
        $_SESSION ['sort_count'] = 0;
    

    for ($i = 0; $i <= $students_qty ; $i++){
        
        $student_id[$i] = trim ($student_id[$i] );
            
        $student_details = file ('./db/s_db/' . $student_id[$i] .'/data.txt' ) ;
            $class[$i] = trim ($student_details[0] ) ;
            $name[$i] = $student_details[1];
            $surname[$i] = $student_details[2];		
            $s_id[$i] = $student_id[$i];
    }
    
    if (!empty($sort)) 
        $_SESSION['sorted_st_all'] = $sort;
    
    
    if (isset ($name) && isset ($surname) && isset ($class))
        switch($_SESSION['sorted_st_all']) {
            case '1':	array_multisort($class, $name, $surname, $s_id);break;
            case '2':	array_multisort($name, $class, $surname, $s_id);break;	
            case '3':	array_multisort($surname, $name, $class, $s_id);break;	
            case '4':	array_multisort($s_id, $name, $surname, $class);break;	
        }
        
    // display all students
    if ( ($status == "all") || ($status == "") && ($_SESSION['sort_count'] == 0) ) {							
        for($i = 0; $i <= $students_qty; $i++) {
            if ( ($class[$i] == 0) && is_numeric($class[$i]) ) $class[$i] = "no class";
            if ( ($class[$i] == 2) && is_numeric($class[$i]) ) $class[$i] = "graduate";				
            echo "
                <tr>
                    <td >". $s_id[$i] ."</td>
                        <td>". $name[$i] ."</td>
                        <td>". $surname[$i] ."</td>
                        <td>". $class[$i] ."</td>							
                        <form action = $action method = post>
                            <input type = hidden value = $current_class name = c_name>
                            <input name = s_id type = hidden value = $s_id[$i]>
                            <input type = hidden value = $value name = action>
                        <td><input class = button_details type = submit value = $value></td>			
                        </form>
                </tr>";
        }
    // sorting type
    $_SESSION['sort_count'] = 0;
    }
   
   
    // display graduates students
    if ( ($status == "graduate")  || (($status !== "noclass") && ($_SESSION['sort_count'] == 1) ) ) {					
        
        for ($i = 0; $i <= $students_qty; $i++){
            if ( ($class[$i] == 2) &&  ( is_numeric ( $class[$i] ) ) )				
            echo "
                <tr>
                    <td>". $s_id[$i] ."</td>
                    <td>". $name[$i] ."</td>
                    <td>". $surname[$i] ."</td>
                    <td>graduate</td>							
                    
                        <form action = $action method = post>
                        <input type = hidden value = $current_class name = c_name>
                        <input name = s_id type = hidden value = $s_id[$i]>
                        <input type = hidden value = $value name = action>
                    <td><input class = button_details type = submit value = $value></td>			
                        </form>
                </tr>";
        }	
    // sorting type
    $_SESSION['sort_count'] = 1;
    }


    // display students without class
    if ( ($status == "noclass")  ||  ($_SESSION['sort_count'] == 2) ) {					
    
        for($i = 0; $i <= $students_qty; $i++){
            
            if (( $class[$i] == 0) && ( is_numeric ($class[$i] ) ) )		
            echo "
                <tr>
                    <td>". $s_id[$i] ."</td>
                        <td>". $name[$i] ."</td>
                        <td>". $surname[$i] ."</td>
                        <td>no class</td>							
                        <form action = $action method = post>
                            <input type = hidden value = $current_class name = c_name>
                            <input name = s_id type = hidden value = $s_id[$i]>
                            <input type = hidden value = $value name = action>
                        <td><input class = button_details type = submit value = $value></td>			
                        </form>
                </tr>";
        }
    // sorting type
    $_SESSION['sort_count'] = 2;
    }
}



/**
* Delete a class      
* 
* This function reads students into array
* they are moved from deleted class, so change class status on 0 
* if all is ok then delete class file
*
* @param $name - name of class
*/
public function deleteClass($name){    
             
	$name = trim ($name);
    
    if (!empty ($name) ) {        
        
        $class = file ('./db/c_db/' . $name . '.txt');
        
        // -3 beacuse profile line and teacher line
        $count = count ($class) - 3;
       
        // this loop changes class status for students from deleted class
        for ($i = 0; $i <= $count; $i++) {

            $class[$i] = trim ( $class[$i] );
        
            $path = './db/s_db/' . $class[$i] . './data.txt';    

             if (file_put_contents 
                 ($path, 
                 str_replace ($class, '0', file_get_contents ($path) ), 
                 LOCK_EX) !== false)                    
                    $this->success[] = 'Class status for students is changed<br>';
             else
                $this->errors[] = 'Cannot change status<br>';
        }
    
    // if parameter is empty then display error
    }else
		$this->errors[] = 'Field cannot be empty';

    
    // if no errors, then delete a class file           
    if (empty ($errors) )
        if (unlink ('./db/c_db/' . $name . '.txt') ) {
         $this->success[] = $name . ' is deleted!';
         
        }else 
            $this->errors[] = $name . ' cannot be deleted';
        
        return $this;
}

/**
* Delete a subject     
* 
* Read subjects into array
* Loop checks if subjects is already deleted, if not then delete 
* 
*
*
* @param $subject - ..
*/	
public function deleteSubject($subject){	

    $subjects = file ('./db/subjects.txt');
    $subjects_qty = count($subjects) -1;   
    
    for ($i = 0; $i <= $subjects_qty; $i++) {
        if  ( ($subjects[$i] == $subject)  &&  (strpos ($subjects[$i], 'deleted') === false) ){
            $subjects[$i] = trim ($subjects[$i] );        
            $subjects[$i] .= ' - subject deleted'.PHP_EOL;
        }
    }          

    if (file_put_contents ('./db/subjects.txt', $subjects , LOCK_EX) !== false);
            $this->succes[] = 'Subject is deleted';
            
    return $this;

}

/**
* Move student out from class    
* 
* This function move student out from class
* It set status '0', wchich mean no class
*
*
* @param $class - name of class
* @param $student_id - ..
*/
public function moveStudentOut($class, $student_id){		
     
    $path = './db/c_db/' . $class . '.txt';
    
    $class_content = file_get_contents($path);
   
    if (file_put_contents ($path, str_replace ($student_id.PHP_EOL , '' , $class_content) ) !== false ) {    
        
        $this->success[] = $student_id . ' is removed from class<br>';
         
        // change class in student data
        $path = './db/s_db/' . $student_id. '/data.txt';
        
        if (file_put_contents ($path,  
            str_replace ($class , '0', file_get_contents ($path) ), 
            LOCK_EX) !== false )
                
                $this->success[] = $student_id . ' class status for student is changed';

            else 
                $this->errors[] = 'Something went wrong<br>'; 
     
    
    } else {
        $this->errors[] = 'Something went wrong<br>';

    }     
           
        
    
    return $this;
}

/**
* Move student to class     
* 
* This function move student into class
* It set class name on class status
*
*
* @param $class - name of class
* @param $student_id - ..
*/
public function moveStudentIn($class, $student_id){
    
    $path = './db/c_db/' . $class . '.txt';  
    $class_content = file_get_contents ($path);	


    if (!strstr ($class_content, $student_id) ) {	
        
        if (file_put_contents ($path, $student_id.PHP_EOL.$class_content) !== false) {
                $path = './db/s_db/' .$student_id . '/data.txt';
            
                $student_details = explode (PHP_EOL, file_get_contents ($path) );
            
                $student_details[0] = $class;
            
                    if (file_put_contents ($path, implode (PHP_EOL, $student_details ), LOCK_EX ) !== false)                    
                        $this->success[] = 'Students is moved to ' . $class;

                    else 
                        $this->errors[] = 'Something went wrong';
        }
    }
    
    else $this->errors[] = 'Student already in class';


    return $this;
}



/**
* Create new class      
* 
* This function creates a new empty file
* Content to lines -> NoTeacher and NoProfile
* Check if file exist
* If no errors then save 
*
* @param $name of class
*/
public function createClass($name){	
    
    $name = trim ($name);	
    
    $name = strtolower ($name);		
    
    $path = './db/c_db/' . $name . '.txt';

    if (!file_exists ($path) && (!empty ($name) ) ) {
        
        if (file_put_contents ($path, 'NoTeacher' . PHP_EOL . 'NoProfile', LOCK_EX ) !== false )
            $this->success[] = $name . ' is succesfully saved!<br>';
        
        else $this->errors[] = 'Something went wrong';
        
    }else
        $this->errors[] = 'Something went wrong';		
    			
    return $this;	
}				

/**
*    
* Save subject
*  
* Checks validation and subject does exist
* Save if no errors
*
* @protected function
* @param $subject - ..
* 
*/
public function saveSubject($subject){
        
    $subject = $this->inputTrim ($subject);     
    $subject = mb_strtolower ($subject);				
    $subjects = file ('./db/subjects.txt');  
    $subjects_qty = count($subjects) -1;

    
    if (!preg_match("/^[a-zA-Z- ]+$/", $subject)) 		
            $this->errors[] = "Invalid subject name<br>";

    for ($i = 0; $i <= $subjects_qty; $i++) {
       
        $subjects[$i] = trim ($subjects[$i]);
        
        if ($subjects[$i] == $subject)    
            $this->errors[] = "Subject already exist<br>";
        }  
        
    if (empty ($this->errors) )
        if (file_put_contents ('./db/subjects.txt', $subject.PHP_EOL, FILE_APPEND | LOCK_EX) !== false )
            $this->success[] = 'Subject is saved';
        else 
            $this->errors[] = 'Something went wrong';
    
    
    return $this;
}


/**
*    
* Save student
*  
* This function checks validation for every field
* If validation is ok and student does not exist, then save
* 
*/

public function saveStudent(){
    
    if (!empty ($_POST) ) {
    $this->checkName			($_POST ['name']   ); 
	$this->checkSurname		    ($_POST ['surname']);
	$this->checkId				($_POST ['id']     );
	$this->checkIdSpr			($_POST ['id_spr'] );
	$this->checkTel			    ($_POST ['tel']    );
	$this->checkEmail			($_POST ['email']  );
	$this->checkCity			($_POST ['city']   );
	$this->checkCode			($_POST ['code']   );
	$this->checkStreet			($_POST ['street'] );
    $this->checkHouseNr		    ($_POST ['housenr']);
    if (file_exists ('./db/s_db/'. $this->id .'/data.txt') )
        $this->errors[] = 'Student already exist';
    }  

    if (empty ($this->errors) && (!empty ($_POST)) ) {
         // create directory	
         mkdir('./db/s_db/'.$this->id, 0777, true) or die("Something went wrong");;

     //	TRY TO LOCK THE FILE, IF OK THEN PUT INFO IN S_DATA, SAVE AND UNLOCK
            $fp = fopen('./db/s_db/' . $this->id . '/data.txt', 'w') or die("Something went wrong");
            if(flock($fp,	LOCK_EX)){
                $s_data='0' . PHP_EOL .
                $this->name. PHP_EOL .
                $this->surname. PHP_EOL .
                $this->id_supervisor. PHP_EOL .
                $this->tel. PHP_EOL .
                $this->email. PHP_EOL  .
                $this->city. PHP_EOL .
                $this->code. PHP_EOL .
                $this->street. PHP_EOL .
                $this->housenr. PHP_EOL;	 						
                
                
                fputs($fp, $s_data);	
                flock($fp,	LOCK_UN);
        
            //MESSAGE IF ALL OK
            $this->success[] = "Student ". $this->name. " " .$this->surname. " " .$this->id. " is saved.";
            }

    
        //CLOSE THE FILE
        fclose($fp); 
    }
        return $this;
}			


/**
*    
* Save student
*  
* This function checks validation for every field
* If validation is ok and student does not exist, then save
* 
*/

public function saveTeacher(){
    
    if (!empty ($_POST) ) {
    $this->checkName			($_POST ['name']   ); 
	$this->checkSurname		    ($_POST ['surname']);
	$this->checkId				($_POST ['id']     );
	$this->checkTel			    ($_POST ['tel']    );
	$this->checkEmail			($_POST ['email']  );
	$this->checkCity			($_POST ['city']   );
	$this->checkCode			($_POST ['code']   );
	$this->checkStreet			($_POST ['street'] );
    $this->checkHouseNr		    ($_POST ['housenr']);
    if (file_exists ('./db/t_db/'. $this->id .'.txt') )
        $this->errors[] = 'Teacher already exist';
    }  

    if (empty ($this->errors) && (!empty ($_POST)) ) {

     //	TRY TO LOCK THE FILE, IF OK THEN PUT INFO IN S_DATA, SAVE AND UNLOCK
            $fp = fopen('./db/t_db/' . $this->id . '.txt', 'w') or die("Something went wrong");
            if(flock($fp,	LOCK_EX)){
                $t_data= 
                ($_POST ['subject_1']) . '|' .
                ($_POST ['subject_2']) . '|' .
                ($_POST ['subject_3']) . '|' . PHP_EOL .
                $this->name. PHP_EOL .
                $this->surname. PHP_EOL .
                $this->tel. PHP_EOL .
                $this->email. PHP_EOL  .
                $this->city. PHP_EOL .
                $this->code. PHP_EOL .
                $this->street. PHP_EOL .
                $this->housenr. PHP_EOL;	 						
                          
                fputs($fp, $t_data);	
                flock($fp,	LOCK_UN);
        
            //MESSAGE IF ALL OK
            $this->success[] = "Teacher ". $this->name. " " .$this->surname. " " .$this->id. " is saved.";
            }

    
        //CLOSE THE FILE
        fclose($fp); 
    }
        return $this;
}			


/**
* Change teacher      
* 
* This function changing main teacher for current class
* Reads class file into array, find teacher, change it and save
* 
*
* @param $class - ..
* @param $teacher_id - ..
*/
public function changeTeacher($class,$teacher_id){
		
    $path = './db/c_db/' . $class . '.txt';
    $class_content = array_reverse (file ($path) );
    
    //this is teacher line in classID.txt
    $class_content[1] = $teacher_id.PHP_EOL;
        
    $class_content = array_reverse ($class_content);	
        
        if (file_put_contents ($path, $class_content, LOCK_EX) !== false)	
            $this->success[] = 'Teacher is changed';
        else 
            $this->errors[] = 'Something went wrong';
    
    return $this;
}	

/**
* Change class profile      
* 
* This function changing class profile
* Reads class file into array, find profile line, change it and save
* 
*
* @param $class - ..
* @param $profile - ..
*/
public function changeProfile($class, $profile){
		
	$path = './db/c_db/' . $class . '.txt';
    $class_content = array_reverse (file ($path) );
    
    //this is profile line in classID.txt
    $class_content[0] = $profile;
        
    $class_content = array_reverse ($class_content);	
        
        if (file_put_contents ($path, $class_content, LOCK_EX) !== false)	
            $this->success[] = 'Profile is changed';
        else 
            $this->errors[] = 'Something went wrong';
    
    return $this;
}



/**
*    
* Checks school year validation
*
* @private function
* @param $input - ..
* 
*/	
private function checkYear($input){
    $input = $this->inputTrim($input);
    
    if (!preg_match("/^[2]{1}[0]{1}[0-9]{2}\/[2]{1}[0]{1}[0-9]{2}$/", $input)) 		
        $this->errors[] = 'Year is not valid';
    else
        $this->year = $input;
}
	
/**
*    
* Checks name validation
*
* @private function
* @param $name - ..
* 
*/
private function checkName($name){
		$name = $this->inputTrim($name);
		
		if (!preg_match("/^[a-zA-Z]+$/", $name)) 		
			$this->errors[] = "Name contains wrong characters<br>";
		else
			$this->name = $name;
	}
/**
*    
* Checks surname validation
*
* @private function
* @param $surname - ..
* 
*/	
private function checkSurname($surname){
		$surname = $this->inputTrim($surname);		
			
			if (!preg_match("/^[a-zA-Z-']+$/", $surname)) 	
				$this->errors[] = "Surname contains wrong characters<br>";
			else
				$this->surname = $surname;
			
	}
/**
*    
* Checks ID validation
*
* @private function
* @param $id - ..
* 
*/	
private function checkId($id){
		$id = $this->inputTrim($id);
		
		if (!preg_match("/^[0-9]{6}$/", $id)) 		
			$this->errors[] = "ID is not valid<br>";
		else
			$this->id = $id;
	
	}
/**
*    
* Checks ID supervisor validation
*
* @private function
* @param $id_supervisor - ..
* 
*/	
private function checkIdSpr($id_supervisor){
		$id_supervisor = $this->inputTrim($id_supervisor);
		
		if (!preg_match("/^[0-9]{6}$/", $id_supervisor)) 		
			$this->errors[] = "ID is not valid<br>";
		else
			$this->id_supervisor = $id_supervisor;
	
	}
/**
*    
* Checks telephone validation
*
* @private function
* @param $tel - ..
* 
*/	
private function checkTel($tel){
		$tel = $this->inputTrim($tel);
		
		if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{2}$/", $tel)) 		
			$this->errors[] = "Telephone number is not valid<br>";
		else
			$this->tel = $tel;
	}
/**
*    
* Checks email validation
*
* @private function
* @param $email - ..
* 
*/	
private function checkEmail($email){
		$email = $this->inputTrim($email);
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			$this->errors[] = "E-mail address is not valid<br>";	
		else
			$this->email = $email;
	}
/**
*    
* Checks city validation
*
* @private function
* @param $city - ..
* 
*/	
private function checkCity($city){
		$city = $this->inputTrim($city);
		
		if (!preg_match("/^[a-zA-Z-' ]+$/", $city)) 	
			$this->errors[] = "City contains wrong characters<br>";
		else
			$this->city = $city;
	}
/**
*    
* Checks post code validation
*
* @private function
* @param $code - ..
* 
*/	
private function checkCode($code){
		$code = $this->inputTrim($code);
		
		if (!preg_match("/^[0-9]{4}$/", $code)) 		
			$this->errors[] = "Wrong city code<br>";
		else
			$this->code = $code;
	}
/**
*    
* Checks street validation
*
* @private function
* @param $street - ..
* 
*/	
private function checkStreet($street){
		$street = $this->inputTrim($street);
		
		if (!preg_match("/^[a-zA-Z-' ]+$/", $street)) 	
			$this->errors[] = "Street contains wrong characters<br>";
		else
			$this->street = $street;
	}
/**
*    
* Checks house nr validation
*
* @private function
* @param $hosuenr - ..
* 
*/	
private function checkHouseNr($housenr){
		$housenr = $this->inputTrim($housenr);
		
		
		if (($housenr==0) || (strlen($housenr)>3) || (!preg_match("/^[0-9]/", $housenr) ))			
				$this->errors[] = "Wrong house nr<br>";
			else
				$this->housenr = $housenr;
	}

    


	

	




 // EOF   
}