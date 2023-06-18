<?php
require_once 'bootstrap.php';

if(isset($_POST["email"]) && isset($_POST["password"])){
    $password = hash('sha256', $_POST["password"]);
    $login_result = $dbh->checkUser($_POST["email"], $password);
    if(count($login_result) == 0){
        //Login fallito
        $templateParams["errore"] = "Errore! Email o password sbagliata!";
    }
    else{
        registerLoggedUser($login_result[0]);
    }
}

if(isUserLoggedIn()){
    header("location: home.php");
}
else{
    $templateParams["titolo"] = "login";
    $templateParams["nome"] = "login-form.php";
}

require 'template/base.php';
?>