<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/php/egradesbook/functions/class.logger.php";
$database = new Database();
$login = new Logger($database);


if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login->logIn($_POST['login'], $_POST['password']);
    }else {
        $login->logOut();
    }

?>
