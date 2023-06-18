<?php
require_once 'bootstrap.php';

if(isUserLoggedIn()){
    header("location: login.php");
}

if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["username"]) && isset($_POST["birth"])){

    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $test = $dbh->checkUser($email, "", $username);

    if(isset($test[0]) && $test[0]["email"] === $email) {
        $templateParams["errore"] = "La e-mail inserita è usata da un altro profilo";
    }

    if(isset($test[0]) && $test[0]["nome_utente"] === $username) {
        $templateParams["errore"] = "Il nome utente inserito è usato da un altro profilo";
    }
    
    if(!isset($templateParams["errore"])){
        $password = hash('sha256', $_POST["password"]);
        $registration_result = $dbh->insertUser($email, $password, $_POST["birth"], $username, "default_pfp.jpg");
        
        header("location: login.php");
    }
}

$templateParams["titolo"] = "register";
$templateParams["nome"] = "register-form.php";


require 'template/base.php';
?>