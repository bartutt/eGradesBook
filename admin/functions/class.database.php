<?php
require_once './functions/class.validator.php';

/**
* Database for school      
* 
* @author Bartlomiej Witkowski
* 
*
*/


class DataBase{
    
    
  /**    
    *	contain errors wchich came while processing
    *
    * @var array
    */    

        private $errors = array();
    
  /**    
    *	contain information what was done
    *
    * @var array
    */ 
        private $success = array();


  /**    
    *	containts list of years
    *
    */ 
        private $years = array();

  /**    
    *	containts list of years
    *
    */ 
        private $lesson_times = array();

  /**    
    *	containts list of years
    *
    */ 
        private $marks_cat = array();
    
    /**    
    *	containts list of roles/status
    *
    */ 
    private $role_status = array();

  /**    
    *	connection to database
    *
    */ 
        private $conn;

        private $pre_stmt;



//PUBLIC METHODS

/** 
* return status/role
*/
public function getRoleStatus(){
    
    $this->connectDB();

    $this->readTable('role_status', 'role_status');
    
    return $this->role_status;
}
/** 
* return marks categories
*/
public function getMarksCat(){
    
    $this->connectDB();

    $this->readTable('marks_cat', 'type');
    
    return $this->marks_cat;
}
/** 
* return years list
*/
public function getYears(){
    
    $this->connectDB();

    $this->readTable('years', 'years');
    
    return $this->years;
}
/** 
* return lesson times list
*/
public function getLessonTimes(){
    
    $this->connectDB();

    $this->readTable('lesson_times', 'time');
    
    return $this->lesson_times;
}
/** 
* return errors
*/
public function getErrors(){

    return $this->errors;

}
/** 
* return success
*/
public function getSuccess(){

    return $this->success;

}
/**   
*
* @param string year 
*/ 
public function addYear($year) {

    $validation = new Validator;

    if ($validation->isValid($year, 'school_year') === true) {
     
        if ($this->insert('years', 'years', $year) === true)
            $this->success[] = $year . ' is saved'; 
        else
            $this->errors[] = $year . ' can not be saved';
        
    }
    else $this->errors[] = 'Year is not valid!';

    return $this;

}
/**
*     
* @param string year
*/ 
public function setYear($year) {
    
    if ($this->updateRows('years', 'current_year', $year, 'LIMIT 1') === true)
        $this->success[] = $year . ' is set as current year'; 
    else
        $this->errors[] = $year . ' can not be set';

    return $this;
} 
/**
*     
*/ 
public function setLessonTime($old_value, $new_value) {
    
    $validation = new Validator;

    if ($validation->isValid ($new_value, 'lesson_time') === true){
        
        if ($this->updateWhere('lesson_times', 'time', $new_value , $old_value, 'time') === true)
            $this->success[] = $old_value . ' is changed to '. $new_value; 
        else
            $this->errors[] = $new_value . ' can not be set';
    }else $this->errors[] = $new_value . ' is not valid!';

    return $this;
} 
/**
*     
*/ 
public function setMarkCat($old_value, $new_value) {
    
    $validation = new Validator;

    if ($validation->isValid ($new_value, 'marks_cat') === true){
        
        if ($this->updateWhere('marks_cat', 'type', $new_value , $old_value, 'type') === true)
            $this->success[] = $old_value . ' is changed to '. $new_value; 
        else
            $this->errors[] = $new_value . ' can not be set';
    }else $this->errors[] = $new_value . ' is not valid!';

    return $this;
} 
/**
*     
*/ 
public function setRoleStatus($old_value, $new_value) {
    
    $validation = new Validator;

    if ($validation->isValid ($new_value, 'role_status') === true){
        
        if ($this->updateWhere('role_status', 'role_status', $new_value , $old_value, 'role_status') === true)
            $this->success[] = $old_value . ' is changed to '. $new_value; 
        else
            $this->errors[] = $new_value . ' can not be set';
    }else $this->errors[] = $new_value . ' is not valid!';

    return $this;
} 
/**
*     
*/ 
public function addMarkCat($value) {
    
    $validation = new Validator;

    if ($validation->isValid ($value, 'marks_cat') === true){
        
        if ($this->insert('marks_cat', 'type', $value) === true)
            $this->success[] = $value . ' is added.'; 
        else
            $this->errors[] = $value . ' can not be add';
    }else $this->errors[] = $value . ' is not valid!';

    return $this;
} 
/**
*     
*/ 
public function addRoleStatus($value) {
    
    $validation = new Validator;

    if ($validation->isValid ($value, 'role_status') === true){
        
        if ($this->insert('role_status', 'role_status', $value) === true)
            $this->success[] = $value . ' is added.'; 
        else
            $this->errors[] = $value . ' can not be add';
    }else $this->errors[] = $value . ' is not valid!';

    return $this;
} 


//PRIVATE METHODS 

/**   
* Connect to DB
*/  
private function connectDB(){
    $server = "127.0.0.1";
    $user = "root";
    $pass = "";
    $dbname = "egradesbook";
    
    $this->conn = new mysqli($server, $user, $pass, $dbname);
    
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
}
/**   
* prepared statement for insert
*
* @param table - name of the table
* @param col - column where value be inserted
* @param value - this will be inserted
*/ 
private function insert($table, $col, $value){

    $this->connectDB();
            
        $this->pre_stmt = $this->conn->prepare("INSERT INTO $table ($col) VALUES (?)");
         
        $this->pre_stmt->bind_param("s", $value); 
        
        if ( $this->pre_stmt->execute() )
            return true;      
        else         
            return false; 
    
            $this->pre_stmt->close();
            $this->conn->close();
}
/**   
* prepared statement for choosed rows
*
* @param table - name of the table
* @param col - column which be updated
* @param value - this will be inserted
* @param limit - number of rows
*/ 
private function updateRows($table, $col, $value, $limit){

    $this->connectDB();
            
        $this->pre_stmt = $this->conn->prepare("UPDATE $table SET $col = ? $limit");
         
        $this->pre_stmt->bind_param("s", $value); 
        
            if ( $this->pre_stmt->execute() )
                return true;      
            else         
                return false; 
    
            $this->pre_stmt->close();
            $this->conn->close();
}
/**   
* prepared statement for update WHERE
*
* @param table - name of the table
* @param col - column which be updated
* @param value - new value for insert
* @param old_value - value of searched aim
* @param where - name for searched column
*/ 
private function updateWhere(
    $table = '', 
    $col = '', 
    $value = '', 
    $old_value = '', 
    $where = ''
    ) {

    $this->connectDB();
            
        $this->pre_stmt = $this->conn->prepare("UPDATE $table SET $col = ? WHERE $where = ?");
        
        $this->pre_stmt->bind_param("ss", $value, $old_value); 

            if ( $this->pre_stmt->execute() )
                return true;      
            else         
                return false; 
    
            $this->pre_stmt->close();
            $this->conn->close();
}
/**    
* This function reads content of choseed column
*
* @param table - name of the table
* @param col - name of column 
*/ 
private function readTable($table, $col){

    $sql = "SELECT $col FROM $table";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
             $this->$table[] = $row [$col];
        }

    }


}








private function addClass($name, $year){

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



private function displayClasses($year){

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

	



 // EOF   
}