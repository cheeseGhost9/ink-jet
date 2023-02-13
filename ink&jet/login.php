<?php
require_once 'bootstrap.php';

if(isset($_POST["email"]) && isset($_POST["password"])){
    $password = hash('sha256', $_POST["password"]);
    $login_result = $dbh->checkLogin($_POST["email"], $password);
    if(count($login_result)==0){
        //Login fallito
        $templateParams["errorelogin"] = "Errore! Controllare email o password!";
    }
    else{
        registerLoggedUser($login_result[0]);
    }
}

if(isUserLoggedIn()){
    if(isUserLoggedIn()){
        header("location: index.php");
    }
}
else{
    $templateParams["titolo"] = "login";
    $templateParams["nome"] = "login-form.php";
}

require 'template/base.php';
?>