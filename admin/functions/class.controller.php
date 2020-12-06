<?php 
/**
* Controller      
* 
* @author Bartlomiej Witkowski
* 
* This is class which control action sent from forms
* Add, change, remove etc...
*/
class Controller {

    private $database;

    private $errors;

    private $success;

    private $displayer;

    /**
    * Contains forms
    */
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

    /**
     * 
     * PRIVATE METHODS
     *
     */

    /**
     * Gives a result of request in SESSION var, because of resubmitting forms
     */
    private function result(){

        $this->errors = $this->database->getErrors();
        $this->success = $this->database->getSuccess();
        
        if (!empty ($this->success)){
            $_SESSION['result'] = $this->success;
            $_SESSION['type'] = 'success';
        }
            
        if (!empty ($this->errors)){
            $_SESSION['result'] = $this->errors;
            $_SESSION['type'] = 'error';
        }
            

    }

    /**
     * Shows start lesson view
     * Return false if class and subject is not set
     */
    private function setClassSubject() {

        if ( (empty ($this->lesson_class)) && (empty($this->lesson_subject)) ){

                $this->displayer->startLesson();

                return false;
        }
            
    }

    /**
     * Check if lesson in choosed day exist
     * Return lesson time
     */
    private function checkTimetable($class, $subject = '', $week_day = '') {

        $values[] = $class;
        $values[] = $subject;
        $values[] = $week_day;

        $lesson_time = $this->database->checkTimetable($values);

        return $lesson_time;
    }

    /**
     * Set active tab
     */
    private function setTab($tab = null) {
      
        if (empty($tab)) {
            $_SESSION['tab'] = 'details';

        }else {
            $_SESSION['tab'] = $tab;
        }
    }

    /**
     * 
     * PUBLIC METHODS
     *
     */


     /**
     * redirect after action to prevent resubmit forms
     */
    public function redirect($index = '', $index2 = '') {

        if (!empty ($_POST['action'])) {
            
            $action = explode('_', $_POST['action']);   
            if (empty ($index)) 
                $index = $action[1];
         
            if (!empty ($_REQUEST[$index])) { 
                $this->handleRequest ($_POST['action'], $_REQUEST[$index], $_REQUEST[$index2]);
                header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
                exit();
            }
        }

    }
    /**
     * Return all forms
     */
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
    
    /**
     * This function set role/status ID in add person form
     */
    public function addPerson($type) {

        $role_status = $this->database->getRoleStatus();

        foreach ($role_status as $role)
          if ($role['name'] == $type)
            echo '<input class = "form-control" form = "add_person" name = "person[]" type = "hidden" value = '.$role['id'] .'>';
    }

    

    /**
     * Read active tab from session
     */
    public function getTab() {

        if (isset ($_SESSION['tab'])) {
            $this->tab[$_SESSION['tab']] = 'active';
            $this->tab[$_SESSION['tab']."_show"] = 'show active';
        }else {
            $this->tab['details'] = 'active';
            $this->tab['details_show'] = 'active show';

        }
    }

    /**
     * 
     */
    public function addMark() {
        
        if (isset ($_SESSION['class']) && (isset ($_SESSION['subject']))) {
            $this->displayer->addMark($_SESSION['class'], $_SESSION['subject']);
        }
    }

    /**
     * 
     */
    public function addNote() {
        
        if (isset ($_SESSION['class']) && (isset ($_SESSION['subject']))) {
            $this->displayer->addNote($_SESSION['class'], $_SESSION['subject']);
        }
    }
    
    /**
     * This function control view under lesson
     * If attendance checked correct go to marks view and stay until finish lesson
     */
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
    /**
     * This function handles all request sent via forms
     * 
     * @param action - name of action/form
     * @param val_1 - value sent from form
     * @param val_2 - value sent from form
     */

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
                $this->setTab('lessons');
                break;
            
            case 'set_attendance':
                $this->database->setAttendance($val_1);
                $this->result();
                $this->setTab('attendance');

                //if attendance checked, go to marks view
                if (!empty ($_POST['lesson']) && (!empty ($this->success))) {
                    $_SESSION['class'] = $_POST['lesson'][0];
                    $_SESSION['subject'] = $_POST['lesson'][1];
                }
                break;
                
            case 'add_marks':
                $this->database->addMark($val_1);
                $this->result();
                break;

            case 'add_note':
                $this->database->addNote($val_1);
                $this->result();
                break;

            case 'set_marks':
                $this->database->setMarks($val_1);
                $this->result();
                $this->setTab('marks');
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

            case 'set_person':
                $this->database->updatePerson($val_1);
                $this->result();
                $this->setTab('details');
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