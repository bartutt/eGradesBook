<?php 

class Controller {

    private $database;

    private $displayer;
    
    private $form;

    private $errors;

    private $success;

    /**
     * Contains info which tab should be active after action
     * 
     */
    public $tab = array();

    function __construct($database, $displayer) {

        $this->database = $database;

        $this->displayer = $displayer;
        
    }
    private function result(){

        $this->errors = $this->database->getErrors();
        $this->success = $this->database->getSuccess();

    }

    private function setClassSubject() {

        if ( (empty ($this->lesson_class)) && (empty($this->lesson_subject)) ){

                $this->displayer->startLesson();

                return false;
        }
            
    }

    private function checkTimetable($class, $subject = '', $week_day = '') {

        $values[] = $class;
        $values[] = $subject;
        $values[] = $week_day;

        $lesson_time = $this->database->checkTimetable($values);

        return $lesson_time;
    }

    public function getForms(){

        return $this->form;

    }
    /**
     * creates html form
     * @param id - form id
     * @param param - send empty param when variable doesn't exist
     */
    public function htmlForm($id, $param = ''){
        
        $this->form .= '
            <form id = "'. $id .'" action = "'.$_SERVER['REQUEST_URI'].'" method = "post" >
                <input type = "hidden" name = "action" value = "'. $id .'">
                <input type = "hidden" name = "'.$param.'" value = "">
            </form >';

    }
    
    public function addPerson($person) {

        foreach ($this->database->getRoleStatus() as $role_status)
          if ($role_status['name'] == $person)
            echo '<input class = "form-control" form = "add_person" name = "person[]" type = "hidden" value = '.$role_status['id'] .'>';
    }

    public function getTab($tab = null){
        
        if (empty($tab)) {
            $this->tab['details'] = 'active';
            $this->tab['details_show'] = 'show active';
        
        }else {
        
            $this->tab[$tab] = 'active';
            $this->tab[$tab."_show"] = 'show active';
        }

    }

    public function addMark() {
        
        if (isset ($_SESSION['class']) && (isset ($_SESSION['subject']))) {
            $this->displayer->addMark($_SESSION['class'], $_SESSION['subject']);
        }
    }
    
    public function startLesson() {      

        $week_day = date("l");

        if (isset ($_SESSION['class']) && (isset ($_SESSION['subject']))){
            $this->displayer->displayClassMarks($_SESSION['class'], $_SESSION['subject']);
     
        }else {

            if ($this->setClassSubject() !== false) {
                
                $lesson_time = $this->checkTimetable($this->lesson_class, $this->lesson_subject, $week_day);
                    
                $this->displayer->checkAttendance($this->lesson_class, $this->lesson_subject, $lesson_time);
            }
        }

       
    }
    public function handleRequest ($action, $val_1 = null, $val_2 = null) {

        switch ($action) {

            case 'start_lesson':
                $this->lesson_class = $val_1[0];
                $this->lesson_subject = $val_1[1];
                break;

            case 'finish_lesson':
                unset($_SESSION['class']);
                unset($_SESSION['subject']);
                break;
            
            case 'add_information':
                $this->database->addInformation($val_1);
                $this->result();
                break;
    
            case 'add_year':
                $this->database->addYear($val_1);
                $this->result();
                break;

            case 'set_year':  
                $this->database->setYear($val_1);
                $this->result();
                break;
            
            case 'set_lesson_time':  
                $this->database->setLessonTime($val_1, $val_2);
                $this->result();
                break;
            
            case 'set_mark_cat':  
                $this->database->setMarkCat($val_1, $val_2);
                $this->result();
                break;
            
            case 'add_mark_cat':  
                $this->database->addMarkCat($val_1);
                $this->result();
                break;

            case 'set_role_status':  
                $this->database->setRoleStatus($val_1, $val_2);
                $this->result();
                break;

            case 'set_subject':
                $this->database->setSubject($val_1, $val_2);
                $this->result();
                break;

            case 'set_profile':
                $this->database->setProfile($val_1, $val_2);
                $this->result();
                break;

            case 'set_teacher_subject':
                $this->database->setTeacherSubject($val_1);
                $this->result();
                break;
            
            case 'set_timetable':
                $this->database->setTimetable($val_1);
                $this->result();
                $this->tab['lessons'] = 'active';
                $this->tab['lessons_show'] = 'show active';
                break;
            
            case 'set_attendance':
                //if attendance checked, go to marks view
                if (!empty ($_POST['lesson'])) {
                    $_SESSION['class'] = $_POST['lesson'][0];
                    $_SESSION['subject'] = $_POST['lesson'][1];
                }

                $this->database->setAttendance($val_1);
                $this->result();
                $this->tab['attendance'] = 'active';
                $this->tab['attendance_show'] = 'show active';
                break;
                
            case 'add_marks':
                $this->database->addMark($val_1);
                $this->result();
                break;

            case 'set_marks':
                $this->database->setMarks($val_1);
                $this->result();
                $this->tab['marks'] = 'active';
                $this->tab['marks_show'] = 'show active';
                break;

            case 'add_event':
                $this->database->addEvent($val_1);
                $this->result();
                break;
                
            case 'set_supervisor_student':
                $this->database->setSupervisorStudent($val_1);
                $this->result();
                break;
    
            case 'add_role_status':  
                $this->database->addRoleStatus($val_1);
                $this->result();
                break;

            case 'add_person':
                $this->database->addPerson($val_1);
                $this->result();
                break;
            
            case 'add_subject':
                $this->database->addSubject($val_1);
                $this->result();
                break;
            
            case 'add_profile':
                $this->database->addProfile($val_1);
                $this->result();
                break;

            case 'add_class':
                $this->database->addClass($val_1);
                $this->result();
                break;

            case 'add_to_class':
                $this->database->addToClass($val_1, $val_2); // $val_1 = id_class, $val_2 = ID student
                $this->result();
                break;
        
            case 'delete_class':
                $this->database->deleteClass($val_1, $val_2); // $val_1 = id class, $val_2 = class name
                $this->result();
                break;    

            case 'delete_event':
                $this->database->deleteEvent($val_1);
                $this->result();
                break;    

            case 'delete_information':
                $this->database->deleteInformation($val_1);
                $this->result();
                break; 
        
            case 'remove_from_class':
                $this->database->removeFromClass($val_1, $val_2); // $val_1 = ID student, $val_2 = id_class
                $this->result();
                break;    
            }


    }

   

}// EOC

?>