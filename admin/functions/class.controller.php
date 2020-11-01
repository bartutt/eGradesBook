<?php 

class Controller {

    private $database;
    
    private $form;

    function __construct($database) {

        $this->database = $database;

    }

    public function getForms(){

        return $this->form;

    }
    
    public function htmlForm($id){
        
        $this->form .= '
            <form id = "'. $id .'" action = "'.$_SERVER['PHP_SELF'].'" method = "post" >
                <input type = "hidden" name = "action" value = "'. $id .'">
                <input type = "hidden" name = "old_value" value = "">
            </form >';

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
            }

    }

    private function result(){

        $this->database->getErrors();
        $this->database->getSuccess();

    }

}// EOC

?>