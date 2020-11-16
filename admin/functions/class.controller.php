<?php 

class Controller {

    private $database;

    private $displayer;
    
    private $form;

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


    
    public function handleRequest ($action, $old_value, $value) {

        switch ($action) {
         
            case 'add_year':
                $this->database->addYear($value);
                $this->result();
                break;

            case 'set_year':  
                $this->database->setYear($value);
                $this->result();
                break;
            
            case 'set_lesson_time':  
                $this->database->setLessonTime($old_value, $value);
                $this->result();
                break;
            
            case 'set_mark_cat':  
                $this->database->setMarkCat($old_value, $value);
                $this->result();
                break;
            
            case 'add_mark_cat':  
                $this->database->addMarkCat($value);
                $this->result();
                break;

            case 'set_role_status':  
                $this->database->setRoleStatus($old_value, $value);
                $this->result();
                break;

            case 'set_subject':
                $this->database->setSubject($old_value, $value);
                $this->result();
                break;

            case 'set_profile':
                $this->database->setProfile($old_value, $value);
                $this->result();
                break;

            case 'set_teacher_subject':
                $this->database->setTeacherSubject($value);
                $this->result();
                break;
    
            case 'add_role_status':  
                $this->database->addRoleStatus($value);
                $this->result();
                break;

            case 'add_person':
                $this->database->addPerson($value);
                $this->result();
                break;
            
            case 'add_subject':
                $this->database->addSubject($value);
                $this->result();
                break;
            
            case 'add_profile':
                $this->database->addProfile($value);
                $this->result();
                break;

            case 'add_class':
                $this->database->addClass($value);
                $this->result();
                break;

            case 'add_to_class':
                $this->database->addToClass($old_value, $value); // old value = id_class, $value = ID student
                $this->result();
                break;
        
            case 'delete_class':
                $this->database->deleteClass($old_value, $value); // old value = class name
                $this->result();
                break;    
        
            case 'remove_from_class':
                $this->database->removeFromClass($old_value, $value); // old value = id_class, $value = ID student
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