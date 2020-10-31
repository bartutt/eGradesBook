<?php 
require_once './functions/variables.php';

class Controller {

    private $database;

    function __construct($database) {

        $this->database = $database;

    }
 
    
    public function handleRequest ($action, $old_value = '', $value) {

        switch ($action) {
         
            case 'add_year':
                $this->database->addYear($value);
                $this->database->getErrors();
                $this->database->getSuccess();
                break;

            case 'set_year':  
                $this->database->setYear($value);
                $this->database->getErrors();
                $this->database->getSuccess();
                break;
            
            case 'set_lesson_time':  
                $this->database->setLessonTime($old_value, $value);
                $this->database->getErrors();
                $this->database->getSuccess();
                break;



            }

    }

}// EOC

?>