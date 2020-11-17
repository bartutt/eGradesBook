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

        private $classes = array();  

        private $class_details = array();
        
        private $classes_qty = array();

        private $profiles = array();

        private $students_class = array();

        private $persons_qty = array();

        private $teacher_subject = array();

        private $teacher_class = array();

        private $supervisor_student = array();
        
    
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
        private $attDays = array();
        private $attendance = array();
        private $month_attendance = array();

  /**    
    *	connection to database
    *
    */ 
        private $conn;

        private $pre_stmt;

        private $query;



//PUBLIC METHODS

/** 
* return new students
*/
public function countNewPersons($role_status){
    
    $this->setQuery("SELECT 
    COUNT(person.id) AS qty
    FROM person
    INNER JOIN role_status ON role_status_id = role_status.id
    WHERE role_status.name = ? AND YEAR(added_date) = ?");

        $school_year = $this->getCurrentYear();

        $year = explode('/', $school_year);
    
            $values[] = $role_status;
            
            $values[] = $year[0];

            $this->getContent($values, 'new_persons');

            return $this->new_persons[0]['qty'];
}


/** 
* return students quantity
*/
public function countPersons($role_status){
    
    unset($this->$role_status);
    
        $this->setQuery("SELECT 
        COUNT(person.id) AS qty
        FROM person
        INNER JOIN role_status ON role_status_id = role_status.id
        WHERE role_status.name = ?");

        $values[] = $role_status;

        $this->getContent($values, $role_status);

        return $this->$role_status[0]['qty'];
}


/** 
* return teacher subjects
*/
public function getTeacherClasses($teacher_id){
    
    $this->setQuery("SELECT 
    classes.name, classes.years, classes.id
    FROM classes
    INNER JOIN person ON id_teacher = person.id
    WHERE id_teacher = ?");

    $values[] = $teacher_id;

    $this->getContent($values, 'teacher_class');

    return $this->teacher_class;
}

/** 
* return teacher subjects
*/
public function getTeacherSubjects($teacher_id){
    
    $this->setQuery("SELECT 
    CONCAT(person.name, ' ', person.surname) AS teacher, subjects.name as subject 
    FROM teacher_subject 
    INNER JOIN person ON id_teacher = person.id
    INNER JOIN subjects ON id_subject = subjects.id
    WHERE id_teacher = ?");

    $values[] = $teacher_id;
    $this->getContent($values, 'teacher_subject');

    return $this->teacher_subject;
}

/** 
* return teacher subjects
*/
public function getSupervisorStudent($supervisor_id){
    
    $this->setQuery("SELECT 
    CONCAT(supervisor.name, ' ', supervisor.surname) AS supervisor, 
    CONCAT(student.name, ' ', student.surname) AS student,
    student.id as student_id
    FROM supervisor_student 
    INNER JOIN person student ON id_student = student.id
    INNER JOIN person supervisor ON id_supervisor = supervisor.id
    WHERE id_supervisor = ?");

    $values[] = $supervisor_id;
    
    $this->getContent($values, 'supervisor_student');

    return $this->supervisor_student;
}



/** 
* return profiles
*/
public function getProfiles(){
    
    $this->setQuery("SELECT * FROM profiles");

    $this->getContent('', 'profiles');

    return $this->profiles;
}

public function getStudentsInClass($class_id){

    $this->setQuery(
        "SELECT 
        CONCAT(student.name, ' ', student.surname) AS student,
            student.id as student_id
        FROM student_class 
        INNER JOIN person as student ON id_student = student.id
        WHERE id_class = ?"
        );
            
        $values[] = $class_id;

        $this->getContent($values, 'students_class');
            
            return $this->students_class;


}

public function getClassDetails($class_id){
    
    $this->setQuery(
        "SELECT 
        CONCAT(person.name, ' ', person.surname) AS teacher,
        classes.id, 
        classes.name,
        profiles.name AS profile, 
        classes.years
        FROM classes
        INNER JOIN person ON id_teacher = person.id
        INNER JOIN profiles ON id_profile = profiles.id   
        WHERE classes.id = ?"
        );
            
        $values[] = $class_id;

        $this->getContent($values, 'class_details');
            
            return $this->class_details;


}

public function getClasses($school_year){
    
    
    $this->setQuery(
        "SELECT 
        CONCAT(person.name, ' ', person.surname) AS teacher,
        classes.id, 
        classes.name,
        profiles.name AS profile, 
        classes.years
        FROM classes
        INNER JOIN person ON id_teacher = person.id
        INNER JOIN profiles ON id_profile = profiles.id   
        WHERE years = ?"
        );
            
        $values[] = $school_year;

        $this->getContent($values, 'classes');
            
            return $this->classes;


}

public function getClassesQty(){
        
        $this->setQuery(

            "SELECT count(name) as qty, classes.years 
            from classes 
            inner join years ON classes.years = years.years
            group by years.years"
            );


        $this->getContent('', 'classes_qty');

        return $this->classes_qty;
}


public function getMarks($subject, $student_id, $sem, $school_year) {
    
    $this->setQuery(
            "SELECT 
            CONCAT(person.name, ' ', person.surname) AS teacher, marks.mark, marks_cat.name AS cat, marks.weight, marks.description, marks.date, subjects.name 
            FROM marks 
            INNER JOIN person ON id_teacher = person.id 
            INNER JOIN marks_cat ON cat_id = marks_cat.id
            INNER JOIN subjects ON id_subject = subjects.id
            WHERE id_student = ? AND subjects.name = ? AND date BETWEEN ? AND ?"
    );
    
    $this->$subject = null; // reset first semester

    $year = explode('/', $school_year);

    $values[] = $student_id;
    $values[] = $subject;
    if ($sem == '1') {
        $values[] = $year[0].'-09-01';
        $values[] = $year[0].'-12-31';
    }
    if ($sem == '2') {
        $values[] = $year[1].'-01-01';
        $values[] = $year[1].'-06-31';
    }

    $this->getContent($values, $subject);
            
        return $this->$subject;

}

public function getAttendance($student_id, $date){
    
    unset($this->attendance);
    
    $this->setQuery(
        "SELECT
        attendance.type, 
        lesson_times.time, 
        attendance.date, 
        subjects.name 
        
        FROM attendance 
        INNER JOIN lesson_times ON lesson_time_id = lesson_times.id 
        INNER JOIN subjects ON id_subject = subjects.id    
        WHERE id_student = ? AND date = ? "
        );
        $values[] = $student_id;
        $values[] = $date;

        $this->getContent($values, 'attendance');
        
        return $this->attendance;


}

public function getNotes($student_id, $school_year){
    
    $this->setQuery(
        "SELECT CONCAT(person.name, ' ', person.surname) AS teacher, notes.description, notes.date, notes.id
        FROM notes 
        INNER JOIN person ON id_teacher = person.id
        WHERE id_student = ? AND date BETWEEN ? AND ?"
    );

    $year = explode('/', $school_year);

    $values[] =  $student_id;
    $values[] = $year[0].'-09-01';
    $values[] = $year[1].'-06-31';

    $this->getContent($values, 'notes');

    return $this->notes;

}

public function getSubjects(){

    if (empty ($this->subjects)) {

    $this->setQuery("SELECT * FROM subjects");

    $this->getContent('', 'subjects');
    }

        return $this->subjects;

}

public function getAttDays($student_id, $school_year){

    $this->setQuery(
        "SELECT date FROM attendance    
        WHERE id_student = ? AND date BETWEEN ? AND ?
        group by attendance.date
        order by date DESC"
        );

        $year = explode('/', $school_year);

        $values[] =  $student_id;
        $values[] = $year[0].'-09-01';
        $values[] = $year[1].'-06-31';
    

        $this->getContent($values, 'attDays');

        return $this->attDays;

}

public function getClassAttendance($class_id, $school_year) {

    $this->setQuery(
        "SELECT 
        DATE_FORMAT(date,'%M') as month,
        SUM(IF(attendance.type = 'present'
               OR attendance.type = 'late', 1, 0)) AS present, 
        SUM(IF(attendance.type = 'absent' 
               OR attendance.type = 'execused', 1, 0)) AS absent,
        COUNT(id) as percent           
        FROM attendance 
        INNER JOIN student_class ON attendance.id_student = student_class.id_student
        AND student_class.id_class = ?
        AND date BETWEEN ? AND ?
        GROUP BY YEAR(date), MONTH(date)"
        );
        $year = explode('/', $school_year);
        
        $values[] =  $class_id;
        $values[] = $year[0].'-09-01';
        $values[] = $year[1].'-06-31';
    

        $this->getContent($values, 'month_attendance');

        return $this->month_attendance;
}



/** 
* return person details
*
* @param type - i.e student, teacher etc
* @param id 
*/
public function getPersonDetails($id){

    $this->setQuery("SELECT * FROM person WHERE id = ?");

    $values[] = $id;

    $this->getContent($values, 'person');

    return $this->person[0];
}

/** 
* return person list
*/

public function getPersons($role_status){
    
    unset($this->$role_status);

        $this->setQuery("SELECT 
        person.id,
        person.name,
        person.surname, 
        person.gender,
        person.tel,
        person.birth_date,
        person.e_mail,
        person.city,
        person.code,
        person.street,
        person.house_nr,
        role_status.name AS role_status
        FROM person
        INNER JOIN role_status ON role_status_id = role_status.id
        WHERE role_status.name = ?;
        ");


        $values[] = $role_status;

        $this->getContent($values, $role_status);

        return $this->$role_status;
}
/** 
* return status/role
*/
public function getRoleStatus(){
    
    $this->connectDB();

    $this->readTable('role_status', '*');
    
    return $this->role_status;
}
/** 
* return marks categories
*/
public function getMarksCat(){
    
    $this->connectDB();

    $this->readTable('marks_cat', 'name');
    
    return $this->marks_cat;
}

/** 
* return current year
*/
public function getCurrentYear(){
    
    $this->connectDB();

    $this->readTable('years', 'current_year', 'current_year');

    return $this->current_year[0]['current_year'];
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

    $this->setQuery("INSERT INTO years (years) VALUES (?)");

    $values[] = $year;

    $validation = new Validator;

    if ($validation->isValid($year, 'school_year') === true) {
     
        if ($this->setContent($values) === true)
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

    $this->setQuery("UPDATE years SET current_year = ? LIMIT 1");

    $values[] = $year;
    
    if ($this->setContent($values) === true)
        $this->success[] = $year . ' is set as current year'; 
    else
        $this->errors[] = $year . ' can not be set';

    return $this;
} 
/**
*     
*/ 
public function setLessonTime($old_value, $new_value) {
    $this->setQuery("UPDATE lesson_times SET time = ? WHERE time = ?");

    $this->connectDB();

    $values[] = $new_value;
    $values[] = $old_value;

    $validation = new Validator;

    if ($validation->isValid ($new_value, 'lesson_time') === true){
        
        if ($this->setContent($values) === true)
            $this->success[] = $old_value . ' is changed to '. $new_value; 
        else
            $this->errors[] = $new_value . ' can not be set';
    }else $this->errors[] = $new_value . ' is not valid!';

    return $this;
} 

/**
*     
*/ 
public function setSubject($old_value, $new_value) {

    $this->setQuery("UPDATE subjects SET name = ? WHERE name = ?");

    $this->connectDB();

    $values[] = $new_value;
    $values[] = $old_value;
    
    $validation = new Validator;

    if ($validation->isValid ($new_value, 'char_space') === true){
        
        if ($this->setContent($values) === true)
            $this->success[] = $old_value . ' is changed to '. $new_value; 
        else
            $this->errors[] = $new_value . ' can not be set';
    }else $this->errors[] = $new_value . ' is not valid!';

    return $this;
} 

/**
*     
*/ 
public function setProfile($old_value, $new_value) {

    $this->setQuery("UPDATE profiles SET name = ? WHERE name = ?");

    $this->connectDB();

    $values[] = $new_value;
    $values[] = $old_value;
    
    $validation = new Validator;

    if ($validation->isValid ($new_value, 'char_space') === true){
        
        if ($this->setContent($values) === true)
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

    $this->setQuery("UPDATE marks_cat SET name = ? WHERE name = ?");

    $this->connectDB();

    $values[] = $new_value;
    $values[] = $old_value;
    
    $validation = new Validator;

    if ($validation->isValid ($new_value, 'marks_cat') === true){
        
        if ($this->setContent($values) === true)
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
    
    $this->setQuery("UPDATE role_status SET name = ? WHERE name = ?");

    $this->connectDB();

    $values[] = $new_value;
    $values[] = $old_value;

    $validation = new Validator;

    if ($validation->isValid ($new_value, 'role_status') === true){
        
        if ($this->setContent($values) === true)
            $this->success[] = $old_value . ' is changed to '. $new_value; 
        else
            $this->errors[] = $new_value . ' can not be set';
    }else $this->errors[] = $new_value . ' is not valid!';

    return $this;
} 

/**
*     
*/ 
public function setTeacherSubject($values) {
    
    $this->setQuery("INSERT INTO teacher_subject (id_teacher, id_subject) VALUES (?, ?)");
   
        if ($this->setContent($values) === true)
            $this->success[] = 'Subject is assigned.'; 
        else
            $this->errors[] = 'Subject can not be assigned';
} 
/**
*     
*/ 
public function setSupervisorStudent($values) {

    $this->setQuery("INSERT INTO supervisor_student (id_student, id_supervisor) VALUES (?, ?)");
   
        if ($this->setContent($values) === true)
            $this->success[] = 'Student is assigned.'; 
        else
            $this->errors[] = 'Student can not be assigned';
} 
/**
*     
*/ 
public function addMarkCat($value) {
    
    $this->setQuery("INSERT INTO marks_cat (name) VALUES (?)");

    $values[] = $value;

    $validation = new Validator;

    if ($validation->isValid ($value, 'marks_cat') === true){
        
        if ($this->setContent($values) === true)
            $this->success[] = $value . ' is added.'; 
        else
            $this->errors[] = $value . ' can not be add';
    }else $this->errors[] = $value . ' is not valid!';

    return $this;
} 
/**
*     
*/ 
public function addSubject($value) {
    
    $this->setQuery("INSERT INTO subjects (name) VALUES (?)");

    $values[] = $value;

    $validation = new Validator;

    if ($validation->isValid ($value, 'char_space') === true){
        
        if ($this->setContent($values) === true)
            $this->success[] = $value . ' is added.'; 
        else
            $this->errors[] = $value . ' can not be add';
    }else $this->errors[] = $value . ' is not valid!';

    return $this;
} 
/**
*     
*/ 
public function addProfile($value) {
    
    $this->setQuery("INSERT INTO profiles (name) VALUES (?)");

    $values[] = $value;

    $validation = new Validator;

    if ($validation->isValid ($value, 'char_space') === true){
        
        if ($this->setContent($values) === true)
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

    $this->setQuery("INSERT INTO role_status (name) VALUES (?)");

    $values[] = $value;
    
    $validation = new Validator;

    if ($validation->isValid ($value, 'role_status') === true){
        
        if ($this->setContent($values) === true)
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

} 
/**
*     
*/ 
public function addClass($value) {

    $this->setQuery("INSERT INTO classes (name, id_teacher, id_profile, years) VALUES (?, ?, ?, ?)");
    
    $validation = new Validator;

    if ($validation->isValid ($value[0], 'class') === true){
        
        if ($this->setContent($value) === true)
            $this->success[] = $value[0] . ' is added.'; 
        else
            $this->errors[] = $value[0] . ' can not be add';
    }else $this->errors[] = $value[0] . ' is not valid!';

    return $this;
}
/**
*     
*/ 
public function addToClass($id_student, $id_class) {
    
    $this->setQuery("INSERT INTO student_class (id_student, id_class) VALUES (?,?)");

    $values[] = $id_student;
    $values[] = $id_class;
        
        if ($this->setContent($values) === true)
            $this->success[] = $id_student . ' is added'; 
        else
            $this->errors[] = $id_student . ' can not be add';

} 

/**
*     
*/ 
public function removeFromClass($id_student, $id_class) {

    $this->setQuery("DELETE FROM student_class WHERE id_student = ? AND id_class = ?");

    $values[] = $id_student;
    $values[] = $id_class;
        
        if ($this->setContent($values) === true)
            $this->success[] = $id_student . ' is removed'; 
        else
            $this->errors[] = $id_student . ' can not be removed';

} 
/**
*     
*/ 
public function deleteClass($class_name, $id_class) {


    $this->setQuery("DELETE FROM classes WHERE id = ?");

    $values[] = $id_class;
        
        if ($this->setContent($values) === true)
            $this->success[] = $class_name . ' is deleted'; 
        else
            $this->errors[] = $class_name . ' can not be removed';

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
            role_status_id,
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

             $this->$var[] = $row;
            }
    
    $this->pre_stmt->close();
    
}


/**    
* This function
*
* @param values - array
* @param var 
*/ 
private function getContent($values = null, $var = null){

    $this->connectDB();
    if (!empty ($values)){
    
        $types = str_repeat('s', count($values));

        $bind_values = [];

        $bind_values[] = $types;
    }

    $sql = $this->query;

    $this->pre_stmt = $this->conn->prepare($sql);
    if (!empty ($values)) {
        foreach ($values as $key => $value)
            $bind_values[] = & $values[$key];
    
        call_user_func_array(array($this->pre_stmt, 'bind_param'), $bind_values);
    }


    if (!$this->pre_stmt->execute() )
        $this->errors[] = 'Something went wrong';
        
        $result = $this->pre_stmt->get_result();
            while ($row = $result->fetch_assoc()) {

             $this->$var[] = $row;
            }
    
    $this->pre_stmt->close();
    

}
/**    
* This function
*
* @param values - array
* @param var 
*/ 
private function setContent($values, $var = null){

    $this->connectDB();

    $types = str_repeat('s', count($values));

    $bind_values = [];

    $bind_values[] = $types;

    $sql = $this->query;

    $this->pre_stmt = $this->conn->prepare($sql);

    foreach ($values as $key => $value)
            $bind_values[] = & $values[$key];
    
    call_user_func_array(array($this->pre_stmt, 'bind_param'), $bind_values);
    
        if ( $this->pre_stmt->execute() )
            return true;      
        else         
            return false; 

            $this->pre_stmt->close();
    

}
 // EOF   
}