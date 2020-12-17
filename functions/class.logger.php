<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";
require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.validator.php";

class Logger{

    function __construct($database) {

        $this->database = $database;
      
    }


private function getUser($id) {

    $user = $this->database->getUser($id);

    $this->pass = $user['password'];
    $this->role = $user['name'];
    $this->name = $user['person_name'];
}

public function logIn($user, $pass) {
    
    $validation = new Validator;

    if ($validation->isValid($user, 'id') === true) {

        $this->getUser($user);
    
        if (password_verify($pass, $this->pass) && $this->role === 'admin') {
            $_SESSION['logged'] = '1';
            $_SESSION['role'] = 'admin';
            $_SESSION['person_name'] = $this->name;
            header ("location: admin/index.php");
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
    session_destroy();
    header ("location: index.php");
    exit;
}



}// end
?>
