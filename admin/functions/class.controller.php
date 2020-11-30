<?php 

class Controller {

    private $database;

    private $displayer;
    
    private $form;

    /**
     * Contains info which tab should be active after action
     * 
     */
    public $tab = array();

    function __construct($database, $displayer) {

        $this->database = $database;

        $this->displayer = $displayer;
        
    }

    public function getForms(){

        return $this->form;

    }
    
    public function htmlForm($id){
        
        $this->form .= '
            <form id = "'. $id .'" action = "'.$_SERVER['REQUEST_URI'].'" method = "post" >
                <input type = "hidden" name = "action" value = "'. $id .'">
                <input type = "hidden" name = "old_value" value = "">
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

    public function handleRequest ($action, $val_1, $val_2) {

        switch ($action) {
    
            case 'add_year':
                $this->database->addYear($val_2);
                $this->result();
                break;

            case 'set_year':  
                $this->database->setYear($val_2);
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
                $this->database->addMarkCat($val_2);
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
                $this->database->setTeacherSubject($val_2);
                $this->result();
                break;
            
            case 'set_timetable':
                $this->database->setTimetable($val_2);
                $this->result();
                break;
            
            case 'set_attendance':
                $this->database->setAttendance($val_2);
                $this->result();
                $this->tab['attendance'] = 'active';
                $this->tab['attendance_show'] = 'show active';
                break;

            case 'set_marks':
                $this->database->setMarks($val_2);
                $this->result();
                $this->tab['marks'] = 'active';
                $this->tab['marks_show'] = 'show active';
                break;

            case 'add_event':
                $this->database->addEvent($val_2);
                $this->result();
                break;
                
            case 'set_supervisor_student':
                $this->database->setSupervisorStudent($val_2); // $val_1 = ID student, $val_2 = ID parent
                $this->result();
                break;
    
            case 'add_role_status':  
                $this->database->addRoleStatus($val_2);
                $this->result();
                break;

            case 'add_person':
                $this->database->addPerson($val_2);
                $this->result();
                break;
            
            case 'add_subject':
                $this->database->addSubject($val_2);
                $this->result();
                break;
            
            case 'add_profile':
                $this->database->addProfile($val_2);
                $this->result();
                break;

            case 'add_class':
                $this->database->addClass($val_2);
                $this->result();
                break;

            case 'add_to_class':
                $this->database->addToClass($val_1, $val_2); // $val_1 = id_class, $val_2 = ID student
                $this->result();
                break;
        
            case 'delete_class':
                $this->database->deleteClass($val_1, $val_2); // $val_1 = class name
                $this->result();
                break;    

            case 'delete_event':
                $this->database->deleteEvent($val_2);
                $this->result();
                break;    
        
            case 'remove_from_class':
                $this->database->removeFromClass($val_1, $val_2); // $val_1 = id_class, $val_2 = ID student
                $this->result();
                break;    
            }


    }

    private function result(){

        $this->database->getErrors();
        $this->database->getSuccess();

    }

}// EOC

?>