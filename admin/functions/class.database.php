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
 
        private $current_year = array();

  /**    
    *	containts list of years
    *
    */ 
        private $lesson_times = array();

        private $category_name = array();

        private $subjects = array();
    
    /**    
    *	containts list of roles/status
    *
    */ 
        private $role_status = array();
    
    /**    
    *	containts person info
    *
    */ 
        private $person = array();
        private $notes = array();
        private $marks = array();

  /**    
    *	connection to database
    *
    */ 
        private $conn;

        private $pre_stmt;

        private $query;



//PUBLIC METHODS


public function getMarks($subject_id, $student_id, $sem, $school_year) {
    
    $this->setQuery(
        "
        SELECT 
            CONCAT(person.name, ' ', person.surname) AS teacher, marks.id_subject, marks.mark, marks_cat.type AS cat, marks.weight, marks.description, marks.date 
            FROM marks 
            INNER JOIN person ON id_teacher = person.id 
            INNER JOIN marks_cat ON cat_id = marks_cat.id
    
            WHERE id_student = ? AND id_subject = ? AND date BETWEEN ? AND ?"
    );
    
    $this->$subject_id = null; // reset first semester

    $this->connectDB();

    $year = explode('/', $school_year);

    $values[] = $student_id;
    $values[] = $subject_id;
    if ($sem == '1') {
        $values[] = $year[0].'-09-01';
        $values[] = $year[0].'-12-31';
    }
    if ($sem == '2') {
        $values[] = $year[1].'-01-01';
        $values[] = $year[1].'-06-31';
    }


    $this->getContent($values, $subject_id);

            return $this->$subject_id;



}

public function getNotes($student_id){
    
    $this->setQuery(
        "
        SELECT CONCAT(person.name, ' ', person.surname) AS teacher, notes.description, notes.date
        FROM notes 
        INNER JOIN person ON id_teacher = person.id
        WHERE id_student = ?"
    );
    
    $this->connectDB();

    $values[] =  $student_id;

    $this->getContent($values, 'notes');

    return $this->notes;

}

public function getSubjects(){

    unset($this->subjects);

    $this->connectDB();

    $this->readTable('subjects', 'id_subject');

    return $this->subjects;

}


/** 
* return person details
*
* @param type - i.e student, teacher etc
* @param id 
*/
public function getPersonDetails($id){

    $this->setQuery("SELECT * FROM person WHERE id = ?");

    $this->connectDB();
    $values[] = $id;

    $this->getContent($values, 'person');

    return $this->person[0];
}

/** 
* return person list
*/

public function getPersons($role_status){
    
    $this->setQuery("SELECT * FROM person WHERE role_status = ?");

    $this->connectDB();

    $values[] = $role_status;

    $this->getContent($values, 'person');
    
    return $this->person;
}
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
* return current year
*/
public function getCurrentYear(){

    $this->current_year = null;
    
    $this->connectDB();

    $this->readTable('years', 'current_year', 'current_year');
    
    return $this->current_year[0];
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
/**
*     
*/ 
public function addPerson($value) {
    
    $validation = new Validator;

    if ($validation->isValid ($value[0], 'id')!== true)
        $this->errors[] ='ID ' .  $value[0] . ' is not valid.';

    if ($validation->isValid ($value[1], 'char_space')!== true)
        $this->errors[] ='Name ' .  $value[1] . ' is not valid.';

    if ($validation->isValid ($value[2], 'char_space')!== true)
        $this->errors[] ='Surname ' .  $value[2] . ' is not valid.';

    if ($validation->isValid ($value[5], 'tel')!== true)
        $this->errors[] = 'Tel ' .  $value[5] . ' is not valid.';

    if ($validation->isValid ($value[6], 'birth_date')!== true)
        $this->errors[] ='Birth date ' .  $value[6] . ' is not valid.';		

    if ($validation->isValid ($value[8], 'char_space')!== true)
        $this->errors[] = 'City ' . $value[8] . ' is not valid.';

    if ($validation->isValid ($value[9], 'code')!== true)
        $this->errors[] = 'Code ' . $value[9] . ' is not valid.';

    if ($validation->isValid ($value[10], 'char_space')!== true)
        $this->errors[] = 'Street ' . $value[10] . ' is not valid.';

    if ($validation->isValid ($value[11], 'house_nr')!== true)
        $this->errors[] = 'Nr ' . $value[11] . ' is not valid.';

    if (!filter_var($value[7], FILTER_VALIDATE_EMAIL))
        $this->errors[] = "E-mail address is not valid<br>";	
    
    if (empty ($this->errors)) {
        if ($this->insertPerson($value) === true)
            $this->success[] = $value[1] .' '. $value[2]  .' is added to database'; 
        else
            $this->errors[] = $value[1] .' '. $value[2] .' can not be add';
    }     
        
    
    

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
* Set query
*/  
private function setQuery($query){
    
    $this->query = $query;

    return $this->query;
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
* prepared statement for insert person
*
* @param value - array with person info
*/ 
private function insertPerson($value){

        $this->connectDB();
            
        $this->pre_stmt = $this->conn->prepare("INSERT INTO PERSON 
        (   id,
            name,
            surname,
            role_status,
            gender,
            tel,
            birth_date,
            e_mail,
            city,
            code,
            street,
            house_nr,
            password

        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
         
        $this->pre_stmt->bind_param("issssssssisss", 
            $value[0], 
            $value[1], 
            $value[2], 
            $value[3],
            $value[4],
            $value[5], 
            $value[6], 
            $value[7], 
            $value[8],
            $value[9],
            $value[10],
            $value[11],
            $value[12]); 

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
* This function 
*
* @param table - name of the table
* @param col - name of column 
* @param var - name of variable which will holds info
*/ 
private function readTable($table, $col, $var = null){

    if (empty ($var)) 
        $var = $table;

    $sql = "SELECT $col FROM $table ";
    
    $this->pre_stmt = $this->conn->prepare($sql);
    
    if (!$this->pre_stmt->execute() )
        $this->errors[] = 'Something went wrong';
        
        $result = $this->pre_stmt->get_result();
            while ($row = $result->fetch_assoc()) {

             $this->$var[] = $row [$col];
            }
    
    $this->pre_stmt->close();
    $this->conn->close();

}


/**    
* This function
*
* @param values - array
* @param var 
*/ 
private function getContent($values, $var = null){

    $types = str_repeat('s', count($values));

    $bind_values = [];

    $bind_values[] = $types;

    $sql = $this->query;

    $this->pre_stmt = $this->conn->prepare($sql);

    foreach ($values as $key => $value)
            $bind_values[] = & $values[$key];
    
    call_user_func_array(array($this->pre_stmt, 'bind_param'), $bind_values);
    
    if (!$this->pre_stmt->execute() )
        $this->errors[] = 'Something went wrong';
        
        $result = $this->pre_stmt->get_result();
            while ($row = $result->fetch_assoc()) {

             $this->$var[] = $row;
            }
    
    $this->pre_stmt->close();
    $this->conn->close();

}

 // EOF   
}