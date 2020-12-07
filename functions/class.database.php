<?php
require_once $_SERVER['DOCUMENT_ROOT']."/egradesbook/functions/class.validator.php";

/**
* Database for school      
* 
* @author Bartlomiej Witkowski
* 
*
*/


class DataBase{
    
 
        private $errors = array();
    
        private $success = array();

        private $years = array();
 
        private $current_year = array();

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

        private $events = array();

        private $calendar_min_max = array();

        private $timetable = array();

        /**
         * Contain subject name fetched by ID
         */
        private $subject_name = array();

        /**    
        *	containts class where student is in current year 
        */ 
        private $student_curr_class;

        /**    
        *	containts list dates where student exist
        */ 
        private $attendance_days = array();
        /**    
        *	containts current year information board
        */ 
        private $information_board;
        
    
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
        private $pass = array();
        private $notes = array();
        private $marks = array();
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
* Get user info
* @param id
*/
public function getUser($id) {
    
    $this->setQuery("SELECT 
    person.name as person_name, password, role_status.name
    FROM person
    INNER JOIN role_status ON role_status_id = role_status.id
    WHERE person.id = ?
    ");

    $values[] = $id;
    
    $this->getContent($values, 'pass');
    if (!empty($this->pass))
        return $this->pass[0];
    else 
        return false;
}


/**
 * Get student actual class based on school year
 * @param id_student
 */
public function getStudentCurrentClass($id_student) {

    $curr_year = $this->getCurrentYear();

    $this->setQuery("SELECT classes.name, classes.id
    FROM student_class
    INNER JOIN classes ON classes.id = id_class
    WHERE id_student = ? AND classes.years = ?");
    
    $values[] = $id_student;
    $values[] = $curr_year;
    
            $this->getContent($values, 'student_curr_class');

            if (empty ($this->student_curr_class)){
                $this->student_curr_class[0]['id'] = '';
                $this->student_curr_class[0]['name'] = 'No class';

            }
                
            return $this->student_curr_class;

    
}

/**
 * Check if lesson exist on current day and choosed class
 * @param values - array - id class, id subject, week day
 */
public function checkTimetable($values) {

    $this->setQuery("SELECT
    CONCAT(teacher.name, ' ', teacher.surname) AS teacher,
    classes.name as class, subjects.name as subject, lesson_times.time,lesson_times.id as time_id,
    week_day

    FROM class_subject
    INNER JOIN classes ON id_class = classes.id
    INNER JOIN subjects ON id_subject = subjects.id
    INNER JOIN lesson_times ON id_lesson_time = lesson_times.id
    INNER JOIN person teacher ON class_subject.id_teacher = teacher.id
    WHERE classes.id = ? AND subjects.id = ? AND week_day = ?");
    

            $this->getContent($values, 'timetable');

            if (!empty ($this->timetable) )
                return $this->timetable[0]['time_id'];


}

/**
 * Get timetable for choosed class
 * @param class_id
 */
public function getTimetable($class_id){

    $this->setQuery("SELECT
    CONCAT(teacher.name, ' ', teacher.surname) AS teacher,
    classes.name as class, subjects.name as subject, lesson_times.time,lesson_times.id as time_id,
    week_day

    FROM class_subject
    INNER JOIN classes ON id_class = classes.id
    INNER JOIN subjects ON id_subject = subjects.id
    INNER JOIN lesson_times ON id_lesson_time = lesson_times.id
    INNER JOIN person teacher ON class_subject.id_teacher = teacher.id
    WHERE classes.id = ?");
    
    $values[] = $class_id;
            $this->getContent($values, 'timetable');

            return $this->timetable;


}

/**
 * Get events for choosed class
 * @param class_id
 */
public function getEvents($class_id) {

        $this->setQuery("SELECT 
        classes.name,events.title, events.description, events.date, events.id, classes.id as class_id 
        FROM events
        INNER JOIN classes ON id_class = classes.id
        WHERE classes.id = ?
        ");

        $value[] = $class_id;
            
            $this->getContent($value, 'events');

            return $this->events;

}

/** 
* Return new persons added on current year based on role - i.e student
* @param role_status
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
* Return persons based on role - i.e student
* @param role_status
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
* Return classes where teacher is a main teacher
* @param teacher_id
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
* Return subjects which teacher can learn
* @param teacher_id
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
* Return children of parent
* @param supervisor_id
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
* Return available profiles
*/
public function getProfiles(){
    
    $this->setQuery("SELECT * FROM profiles");

    $this->getContent('', 'profiles');

    return $this->profiles;
}

/** 
* Get students in class
* @param class_id
*/
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

/** 
* Get class details
* @param class_id
*/
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

/** 
* Get classes based on school year
* @param school_year
*/
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

/** 
* Get classes quantity gruped by year - for chart
*/
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

/** 
* Get marks on class view
* @param class - class id
* @param subject
* @param sem - semester
* @param school_year
*/
public function getClassMarks($class, $subject, $sem, $school_year) {
    
    
    $this->setQuery(
            "SELECT 
            CONCAT(teacher.name, ' ', teacher.surname) AS teacher,
            CONCAT(student.name, ' ', student.surname) AS student,
            marks.id,
            marks.mark, 
            marks_cat.name AS cat, 
            marks.weight, 
            marks.description, 
            marks.date, 
            subjects.name as subject,
            subjects.id as subject_id,
            student_class.id_class
            FROM marks 
            INNER JOIN person teacher ON id_teacher = teacher.id
            INNER JOIN person student ON marks.id_student = student.id 
            INNER JOIN marks_cat ON cat_id = marks_cat.id
            INNER JOIN subjects ON id_subject = subjects.id
            INNER JOIN student_class ON marks.id_student = student_class.id_student
            WHERE student_class.id_class = ? AND subjects.id = ? AND date BETWEEN ? AND ?"
    );
    

    $year = explode('/', $school_year);

    $values[] = $class;
    $values[] = $subject;

    if ($sem == '1') {
        $values[] = $year[0].'-09-01';
        $values[] = $year[0].'-12-31';
    }
    if ($sem == '2') {
        $values[] = $year[1].'-01-01';
        $values[] = $year[1].'-06-31';
    }

    // 2 semester
    if (!empty ($this->marks)) 
            unset ($this->marks);

        $this->getContent($values, 'marks');
            
        return $this->marks;

}

/** 
* Get marks on student view
* @param student_id
* @param sem - semester
* @param school_year
*/
public function getMarks($student_id, $sem, $school_year) {
    
    $this->setQuery(
            "SELECT 
            CONCAT(person.name, ' ', person.surname) AS teacher, 
            marks.id,
            marks.mark, 
            marks_cat.name AS cat, 
            marks.weight, 
            marks.description, 
            marks.date, 
            subjects.name as subject
            FROM marks 
            INNER JOIN person ON id_teacher = person.id 
            INNER JOIN marks_cat ON cat_id = marks_cat.id
            INNER JOIN subjects ON id_subject = subjects.id
            WHERE id_student = ? AND date BETWEEN ? AND ?"
    );
    

    $year = explode('/', $school_year);

    $values[] = $student_id;

    if ($sem == '1') {
        $values[] = $year[0].'-09-01';
        $values[] = $year[0].'-12-31';
    }
    if ($sem == '2') {
        $values[] = $year[1].'-01-01';
        $values[] = $year[1].'-06-31';
    }

    // 2 semester
    if (!empty ($this->marks)) 
        $this->marks = null;

        $this->getContent($values, 'marks');
            
        return $this->marks;

}

/** 
* Get attendance - based on school year or selected date
* @param student_id
* @param school_year
* @param date_from
* @param date_to
*/
public function getAttPeriod($student_id, $school_year = '', $date_from = '', $date_to = '') {
    

    $this->setQuery(
        "SELECT
        attendance.id,
        attendance.type, 
        lesson_times.time, 
        lesson_times.id as time_id,
        attendance.date, 
        subjects.name,
        subjects.id as subject_id
        
        FROM attendance 
        INNER JOIN lesson_times ON lesson_time_id = lesson_times.id 
        INNER JOIN subjects ON id_subject = subjects.id    
        WHERE id_student = ? AND date BETWEEN ? AND ?
        ORDER BY lesson_time_id
        "
        );
    
        if (!empty ($school_year)) {
            $year = explode('/', $school_year);
            $values[] =  $student_id;
            $values[] = $year[0].'-09-01';
            $values[] = $year[1].'-06-31';
        }

        if (!empty ($date_from) && ($date_to)) {
            $values[] = $student_id;         
            $values[] = $date_from;       
            $values[] = $date_to;
        }

 
        if  ($this->getContent($values, 'attendance') !== false)
                return $this->attendance;


}

/** 
* Count days for rendering, based on year or selected date
* @param student_id
* @param school_year
* @param date_from
* @param date_to
*/
public function getAttendanceDays($student_id, $school_year = '', $date_from = '', $date_to = '') {
    

    $this->setQuery(
        "SELECT attendance.date
        
        FROM attendance  
        WHERE id_student = ? AND date BETWEEN ? AND ?
        GROUP by date"
        );

        if (!empty ($school_year)) {
            $year = explode('/', $school_year);
            $values[] =  $student_id;
            $values[] = $year[0].'-09-01';
            $values[] = $year[1].'-06-31';
        }

        if (!empty ($date_from) && ($date_to)) {
            $values[] = $student_id;         
            $values[] = $date_from;       
            $values[] = $date_to;
        }

            if  ($this->getContent($values, 'attendance_days') !== false)
                return $this->attendance_days;


}

/** 
* Class attendance - for chart
* @param class_id
* @param school_year
*/
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
* Student notes based on school year
* @param student_id
* @param school_year
*/
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

/** 
* Return available subjects
*/
public function getSubjects() {

    if (empty ($this->subjects)) {

        $this->setQuery("SELECT * FROM subjects");

        $this->getContent('', 'subjects');
    }

        return $this->subjects;

}

/** 
* Return subject name based on subject id
* @param id
*/
public function getSubjectName($id) {

        $val[] = $id;

        $this->setQuery("SELECT subjects.name FROM subjects WHERE id = ?");

        $this->getContent($val, 'subject_name');

        return $this->subject_name;

}

/** 
* Return information board based on school year
* @param school_year
*/
public function getInformationBoard($school_year){



    $this->setQuery(
        "SELECT title, content, time_added, time_when, id
        FROM information_board 
        WHERE time_when BETWEEN ? AND ?"
    );

    $year = explode('/', $school_year);

    $values[] = $year[0].'-09-01';
    $values[] = $year[1].'-06-31';

    $this->getContent($values, 'information_board');

    return $this->information_board;


}


/** 
* Return semester based on real date 
* @param school_year
*/
public function getCurrentSem($school_year){

    $year = explode('/', $school_year);

    $today = date("Y-m-d"); 

    $y1 = $year[0].'-09-01';
    $y2 = $year[0].'-12-31';
    $y3 = $year[0].'-01-01';
    $y4 = $year[0].'-06-31';


    if ( ($y1 <= $today) && ($y2 >= $today) ) 
        return 1;
    
    if ( ($y3 >= $today) && ($y4 <= $today) ) 
        return 2;
}


/** 
* return person details
* @param id 
*/
public function getPersonDetails($id){

    $this->setQuery("SELECT 
    person.id,
    person.name, 
    person.surname, 
    person.role_status_id,
    person.gender,
    person.tel,
    person.birth_date,
    person.e_mail,
    person.city,
    person.code,
    person.street,
    person.house_nr,
    role_status.name as role_status_name
    FROM person
        INNER JOIN role_status ON role_status_id = role_status.id
    WHERE person.id = ?");

    $values[] = $id;

    $this->getContent($values, 'person');

    return $this->person[0];
}

/** 
* return persons list based on role - i.e student
* @param role_status
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
* Return available status/roles
*/
public function getRoleStatus(){
    
    $this->connectDB();

    $this->readTable('role_status', '*');
    
    return $this->role_status;
}

/** 
* Return available marks categories
*/
public function getMarksCat(){
    
    $this->connectDB();

    $this->readTable('marks_cat', '*');
    
    return $this->marks_cat;
}

/** 
* Return current year
*/
public function getCurrentYear(){
    
    $this->connectDB();

    $this->readTable('years', 'current_year', 'current_year');

    return $this->current_year[0]['current_year'];
}

/** 
* Return available years
*/
public function getYears(){
    
    $this->connectDB();

    $this->readTable('years', 'years');
    
    return $this->years;
}

/** 
* Return lesson times list
*/
public function getLessonTimes(){
    
    if (empty ($this->lesson_times)) {

        $this->setQuery("SELECT * FROM lesson_times");
    
        $this->getContent('', 'lesson_times');
        }
    
            return $this->lesson_times;
}

/** 
* Return errors
*/
public function getErrors(){

    return $this->errors;

}

/** 
* Return success
*/
public function getSuccess(){

    return $this->success;

}

/**   
*
* @param year
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
* Add information to inf board
* @param value - array title, content, date
*/ 
public function addInformation($value) {

    $this->setQuery("INSERT INTO information_board (title, content, time_when) VALUES (?, ?, ?)");


    $validation = new Validator;

    if ( ($validation->isValid($value[0], 'description') === true) 
        && ($validation->isValid($value[1], 'description') === true) ) {
     
        if ($this->setContent($value) === true)
            $this->success[] = 'Information is saved'; 
        else
            $this->errors[] = 'Information can not be saved';
        
    }
    else $this->errors[] = 'Information is not valid!';

    return $this;

}

/**
* Set current year
* @param year
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
* Change time lessons rings
* @param new_value
* @param old_value 
*/ 
public function setLessonTime($new_value, $old_value) {
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
* Change subject name
* @param new_value
* @param old_value 
*/
public function setSubject($new_value, $old_value) {

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
* Change profile name
* @param new_value
* @param old_value 
*/
public function setProfile($new_value, $old_value) {

    $this->setQuery("UPDATE profiles SET name = ? WHERE name = ?");

    $this->connectDB();

    $values[] = $new_value;
    $values[] = $old_value;;
    
    
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
* Change mark category name
* @param new_value
* @param old_value 
*/
public function setMarkCat($new_value, $old_value) {

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
* Change role/status name
* @param new_value
* @param old_value 
*/
public function setRoleStatus($new_value, $old_value) {
    
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
* Assign subject to teacher
* @param values - array id teacher and id subject
*/
public function setTeacherSubject($values) {
    
    $this->setQuery("INSERT INTO teacher_subject (id_teacher, id_subject) VALUES (?, ?)");
   
        if ($this->setContent($values) === true)
            $this->success[] = 'Subject is assigned.'; 
        else
            $this->errors[] = 'Subject can not be assigned';
} 

/**
* Assign parent to student
* @param values - array id teacher and id parent
*/
public function setSupervisorStudent($values) {

    $this->setQuery("INSERT INTO supervisor_student (id_student, id_supervisor) VALUES (?, ?)");
   
        if ($this->setContent($values) === true)
            $this->success[] = 'Student is assigned.'; 
        else
            $this->errors[] = 'Student can not be assigned';
} 

/**
* Set attendance, if date does not exist then insert new value
* Update on existing values
* @param values - array id student, id subject, type, lesson time, date
*/
public function setAttendance($values) {


    foreach ($values as $row) {  

        if ( $row['2'] !== '') {  
 
         $this->setQuery("INSERT INTO 
         attendance (id_student, id_subject, type, lesson_time_id, date) 
         VALUES( ?, ?, ?, ?, ?) 
         ON DUPLICATE KEY UPDATE    
         type = VALUES(type)
         ");
        
             if ($this->setContent($row) === true) {
                 if (empty ($this->success) )
                 $this->success[] = 'Attendance is saved'; 
             
             }else {
                 if (empty ($this->errors) )
                 $this->errors[] = 'Attendance can not be save';
                 }
        }
    }
     
} 

/**
* Add new mark
* @param values - array id student, id teacher, id subject, mark, cat id, weight, desc, date
*/
public function addMark($values) {

    $this->setQuery("INSERT INTO 
    marks (id_student, id_teacher, id_subject, mark, cat_id, weight, description, date) 
    VALUES (?,?,?,?,?,?,?,?)
    ");

    $val = $values[0];

    $validation = new Validator;

    if ($validation->isValid ($val[6], 'description') === true) {
        
        if ($this->setContent($val) === true)
            $this->success[] = 'Mark is added.'; 
        else
            $this->errors[] = 'Mark can not be add';
    
    }else $this->errors[] = $val[6].' is not valid';

        return $this;

}

/**
* Update person info
* @param values - array new value, person id, row in DB which be updated
*/
public function updatePerson($values) {

    $validation = new Validator;
    // check which column will be updated
    if (   ($values[2] === 'name') 
        || ($values[2] === 'surname') 
        || ($values[2] === 'city')
        || ($values[2] === 'street')) 
        {$valid = 'char_space';}

    if  ($values[2] === 'tel') {$valid = 'tel';}
    if  ($values[2] === 'birth_date') {$valid = 'birth_date';}
    if  ($values[2] === 'code') {$valid = 'code';}
    if  ($values[2] === 'house_nr') {$valid = 'house_nr';}
          
    if (!empty ($valid))
        if ($validation->isValid ($values[0], $valid)!== true)
            $this->errors[] = $values[0] . ' is not valid.';
    
    if  ($values[2] === 'e_mail')
        if (!filter_var($values[0], FILTER_VALIDATE_EMAIL))
            $this->errors[] = "E-mail address is not valid<br>";	

    if (empty ($this->errors)) {
        
        $this->setQuery("UPDATE 
        person SET $values[2] = ? WHERE id = ?
        ");

        //row name, unset because to many parameter
        unset ($values[2]);
             if ($this->setContent($values) === true) {
                
                $this->success[] = 'Person is updated'; 
                           
             }else {
                    $this->errors[] = 'Person can not be updated';
                 }
    }
  
} 

/**
* Update marks
* @param values - array mark, id
*/
public function setMarks($values) {


    foreach ($values as $row) {  

        if ( $row['0'] !== '') {  
 
         $this->setQuery("UPDATE 
         marks SET mark = ? WHERE id = ?
         ");
        
             if ($this->setContent($row) === true) {
                 if (empty ($this->success) )
                    $this->success[] = 'Marks are saved'; 
             
             }else {
                 if (empty ($this->errors) )
                    $this->errors[] = 'Marks can not be saved';
                 }
        }
    }
     
} 

/**
* Set timetable, if lesson does not exist then insert new value
* Update on existing values
* @param values - array id class, id subject, id teacher, id lesson time, week day
*/
public function setTimetable($values) {

   foreach ($values as $row) {  
    // row 1 = subject, row 2 = teacher
    if ( ($row['1'] !== '') && ($row['2'] !== '')) {  

        $this->setQuery("INSERT INTO 
        class_subject (id_class, id_subject, id_teacher, id_lesson_time, week_day) 
        VALUES(?, ?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE    
        id_subject = VALUES(id_subject), 
        id_teacher = VALUES(id_teacher), 
        id_lesson_time = VALUES(id_lesson_time)
        ");
       
            if ($this->setContent($row) === true) {
                if (empty ($this->success) )
                $this->success[] = 'Timetable is saved'; 
            
            }else {
                if (empty ($this->errors) )
                $this->errors[] = 'Timetable can not be save';
                }
        }
    }
} 


/**
* Add new mark category
* @param value - name    
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
* Add note
* @param values - array id_student, id_teacher, description, date
*/ 
public function addNote($values) {
    
    $this->setQuery("INSERT INTO notes (id_student, id_teacher, description, date) VALUES (?,?,?,?)");

    $validation = new Validator;

    if ($validation->isValid ($values[2], 'description') === true)  {
        
        if ($this->setContent($values) === true)
            $this->success[] = 'Note is added.'; 
        else
            $this->errors[] = 'Note can not be add';
    }else $this->errors[] = $values[2] .' is not valid';

    return $this;
} 

/**
* Add event
* @param values - array id class, tite, desc, date
*/ 
public function addEvent($values) {
    
    $this->setQuery("INSERT INTO events (id_class, title, description, date) VALUES (?,?,?,?)");

    $validation = new Validator;

    if (($validation->isValid ($values[1], 'description') === true) 
        && ($validation->isValid ($values[2], 'description') === true)) {
        
        if ($this->setContent($values) === true)
            $this->success[] = 'New event is added.'; 
        else
            $this->errors[] = 'Event can not be add';
    }else $this->errors[] = $values[1] . ' or '.$values[2].' is not valid';

    return $this;
} 

/**
* Add subject
* @param value - name
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
* Add profile
* @param value - name
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
* Add role/status
* @param value - name
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
* Add new person
* @param value - array - person info
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
* Add class
* @param value - array - name, id teacher, id profile, years
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
* Assign student to class
* @param id_class
* @param id_student
*/  
public function addToClass($id_class, $id_student) {
    
    $this->setQuery("INSERT INTO student_class (id_student, id_class) VALUES (?,?)");

    $values[] = $id_student;
    $values[] = $id_class;
    
        
        if ($this->setContent($values) === true)
            $this->success[] = 'Student is added'; 
        else
            $this->errors[] = 'Student can not be add. Check if is already in class.';

} 

/**
* Remove student from class
* @param id_class
* @param id_student
*/  
public function removeFromClass($id_class, $id_student) {

    $this->setQuery("DELETE FROM student_class WHERE id_student = ? AND id_class = ?");

    $values[] = $id_student;
    $values[] = $id_class;
        
        if ($this->setContent($values) === true)
            $this->success[] = 'Student is removed'; 
        else
            $this->errors[] = 'Student can not be removed';

} 

/**
* Delete class
* @param id_class
* @param class_name - this is for result display which class was removed
*/ 
public function deleteClass($id_class, $class_name) {


    $this->setQuery("DELETE FROM classes WHERE id = ?");

    $values[] = $id_class;
        
        if ($this->setContent($values) === true)
            $this->success[] = $class_name . ' is deleted'; 
        else
            $this->errors[] = $class_name . ' can not be removed';

} 

/**
* Delete event
* @param ev_id - event id
*/ 
public function deleteEvent($ev_id) {


    $this->setQuery("DELETE FROM events WHERE id = ?");

        
        if ($this->setContent($ev_id) === true)
            $this->success[] = 'Event is deleted'; 
        else
            $this->errors[] = 'Event can not be deleted';

} 

/**
* Delete information from board
* @param inf_id - information id
*/ 
public function deleteInformation($inf_id) {


    $this->setQuery("DELETE FROM information_board WHERE id = ?");

        
        if ($this->setContent($inf_id) === true)
            $this->success[] = 'Information is deleted'; 
        else
            $this->errors[] = 'Information can not be deleted';

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
* Read table
*
* @param table - name of the table
* @param col - name of column 
* @param var - name of variable where content will be set
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
* This fetch content from DB
*
* @param values - array - 
* @param var - name of variable where content will be set
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


    if (!$this->pre_stmt->execute() ){
        $this->errors[] = 'Something went wrong';
        return false;
    }
        $result = $this->pre_stmt->get_result();
            while ($row = $result->fetch_assoc()) {

             $this->$var[] = $row;
            }
    
    $this->pre_stmt->close();
    

}
/**    
* Set content in DB
*
* @param values - array
*/ 
private function setContent($values) {

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