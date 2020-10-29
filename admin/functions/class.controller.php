<?php 
require_once './functions/class.database.php';
require_once './functions/class.random_person.php';
require_once './functions/variables.php';

class Controller{


    private function addYear(){

        $add_year = new DataBase;
		$add_year->addYear($_POST['year'])->isSuccess()->getErrors();

    }

	

    
    
    
    private function handleRequest ($action) {

        switch ( $_POST['action'] ){
            case 'add':
                $this->addYear();
                break;



    }




}
?>