<?php
require_once 'bootstrap.php';

if(!isUserLoggedIn()){
    header("location: login.php");
}

if( (isset($_GET["id"]) && count($dbh->checkIfUserPost($_SESSION["id_utente"], $_GET["id"])) === 0) || !isset($_COOKIE["azione"]) ){
    header("location: home.php");
}

if(isset($_COOKIE["azione"]) && $_COOKIE["azione"]!=1){
    if(!isset($_GET["id"])){
        header("location: home.php");
    } else {
        $risultato = $dbh->getPostAndUser($_GET["id"]);
        if(count($risultato) === 0){
            $templateParams["post"] = null;
        }
        else{
            $templateParams["post"] = $risultato[0];
        }
    }
}
else{
    $templateParams["post"] = getEmptyPost();
}

$templateParams["titolo"] = "gestisci post";
$templateParams["azione"] = $_COOKIE["azione"];
$templateParams["nome"] = "post-form.php";

require 'template/base.php';
?>