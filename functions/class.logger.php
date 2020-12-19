<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";
require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.validator.php";

class Logger{

    function __construct($database) {

        $this->database = $database;
      
    }

private function setRole() {

    switch($this->role) {

        case 'admin':
            $_SESSION['role'] = 'admin';
            $_SESSION['person_name'] = $this->name;
            break;
        
        case 'student':
            $_SESSION['role'] = 'student';
            $_SESSION['person_name'] = $this->name;
            $_SESSION['person_id'] = $this->person_id;
            break;

    }

}

private function getUser($id) {

    $user = $this->database->getUser($id);

    $this->pass = $user['password'];
    $this->role = $user['name'];
    $this->name = $user['person_name'];
    $this->person_id = $user['person_id'];
}

public function logIn($user, $pass) {
    
    $validation = new Validator;

    if ($validation->isValid($user, 'id') === true) {

        $this->getUser($user);


        if (password_verify($pass, $this->pass)) {
            $_SESSION['logged'] = '1';       
            $this->setRole();
            
            header ("location: ".$this->role."/index.php");
            exit;
        }else{
            header ("location: index.php?msg=error");       
            exit;
            }
    
    }else {
        header ("location: index.php?msg=error");       
        exit;
    }

}

public function isLogged($role) {

    if ($_SESSION['logged'] !== '1' || $_SESSION['role'] !== $role) {
        header ("location: ../index.php");
        exit;
    }
}

public function logOut() {
    unset ($_SESSION['logged']);
    unset ($_SESSION['role']);
    unset ($_SESSION['person_name']);
    if (isset ($_SESSION['person_id']))
        unset ($_SESSION['person_id']);
    session_destroy();
    header ("location: index.php");
    exit;
}



}// end
?>
