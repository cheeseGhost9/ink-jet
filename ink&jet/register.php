<?php
require_once 'bootstrap.php';

if(isUserLoggedIn()){
    header("location: login.php");
}

if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["nomeutente"]) && isset($_POST["datanascita"])){

    $_POST["email"] = trim($_POST["email"]);
    $_POST["nomeutente"] = trim($_POST["nomeutente"]);
    $email_result = $dbh->checkIfEmailExists($_POST["email"]);
    if (isset($email_result[0])) {
        $templateParams["erroreregistration"] = "La e-mail inserita è usata da un altro profilo";
    }

    $username_result = $dbh->checkIfUsernameExists($_POST["nomeutente"]);
    if (isset($username_result[0])) {
        $templateParams["erroreregistration"] = "Il nome utente inserito è usato da un altro profilo";
    }

    if(isset($_FILES["imgprofilo"]) && strlen($_FILES["img_pubblicazione"]["name"]) > 0){
        list($result, $img_name) = uploadImage(UPLOAD_DIR, $_FILES["imgprofilo"]);
    }else{
        $result = 1;
        $img_name = "default_pfp.jpg";
    }
    
    if($result != 0 && !isset($email_result[0]) && !$username_result[0]){
        $password = hash('sha256', $_POST["password"]);
        $registration_result = $dbh->createAccount($_POST["nomeutente"], $_POST["datanascita"], $_POST["email"], $password, "default_pfp.jpg");
        
        header("location: login.php");
    }
}

$templateParams["titolo"] = "register";
$templateParams["nome"] = "register-form.php";


require 'template/base.php';
?>