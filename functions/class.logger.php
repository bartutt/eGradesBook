<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.database.php";
require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.validator.php";

class Logger{

    private $displayer;

    private $database;

    function __construct($database, $displayer = '') {

        $this->database = $database;
        $this->displayer = $displayer;
      
    }


/**
 * This function set session on logged person
 */
private function setRole() {

    switch($this->role) {

        case 'admin':
            $_SESSION['role'] = 'admin';
            $_SESSION['person_name'] = $this->name;
            $_SESSION['person_id'] = $this->person_id;
            break;
        
        case 'student':
            $_SESSION['role'] = 'student';
            $_SESSION['person_name'] = $this->name;
            $_SESSION['person_id'] = $this->person_id;
            break;

        case 'parent':
            $_SESSION['role'] = 'parent';
            $_SESSION['person_name'] = $this->name;
            $_SESSION['person_id'] = $this->person_id;
            break;

        case 'teacher':
            $_SESSION['role'] = 'teacher';
            $_SESSION['person_name'] = $this->name;
            $_SESSION['person_id'] = $this->person_id;
            break;

    }

}
/**
 * This function get info about user
 */
private function getUser($id) {

    $user = $this->database->getUser($id);

    $this->pass = $user['password'];
    $this->role = $user['name'];
    $this->name = $user['person_name'];
    $this->person_id = $user['person_id'];
}

/**
 * This function control password etc
 */
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

/**
 * 
 */

public function isLogged($role, $url = "../index.php") {

    if ($_SESSION['logged'] !== '1' || $_SESSION['role'] !== $role) {
        header ("location: ".$url."");
        exit;
    }
}


/**
 *
 */
public function changePassword($old_pass, $new_pass, $new_pass2) {

    $this->getUser($_SESSION['person_id']);

        if (password_verify($old_pass, $this->pass)) {
                 
            if ( ($new_pass === $new_pass2) && (!empty($new_pass))  && (!empty($new_pass2)) ) {
                
                $values[] = password_hash($new_pass, PASSWORD_DEFAULT);
                $values[] = $_SESSION['person_id'];
                $values[] = 'password';
                
                $this->database->updatePerson($values, 'Password updated', 'Something went wrong, try again');
            } else {              
                $this->database->setMsg('Something went wrong', 'error');
            }
        
        } else {
            $this->logOut();
        }
}

/**
 * 
 */
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
