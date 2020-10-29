<?php 
require_once './functions/class.database.php';
require_once './functions/class.random_person.php';
require_once './functions/variables.php';

class Controller {

    private $database;

    function __construct() {

        $this->database = new DataBase;

    }
 
    public function handleRequest ($action, $value) {

        switch ($action) {
         
            case 'add_year':
                $this->database->addYear($value);
                break;

            case 'set_year':  

                break;
            }

    }

}// EOC

?>