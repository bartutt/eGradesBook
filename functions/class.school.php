<?php 
require_once './functions/class.database.php';
require_once './functions/class.random_person.php';
require_once './functions/variables.php';


class School{

    public $database;

    public function dataBase(){

        $this->database = new DataBase;

        return $this;
    
    }


    use RandomPerson;



}//END OF CLASS


?>