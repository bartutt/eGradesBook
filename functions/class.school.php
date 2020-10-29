<?php 
require_once './functions/class.database.php';
require_once './functions/class.random_person.php';
require_once './functions/variables.php';


class School{

    public $database;

    function __construct(){

        $this->database = new DataBase;

        return $this;
    
    }
    function display(){

        return $this->database;

    }


    use RandomPerson;



}//END OF CLASS


?>