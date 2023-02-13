<?php
require_once 'bootstrap.php';

if(!isUserLoggedIn()){
    header("location: login.php");
}

if( ($_GET["action"] != 1 && $_GET["action"] != 2) || !isset($_GET["action"]) ){
    header("location: profilo.php");
}

$templateParams["titolo"] = "impostazioni";
$templateParams["nome"] = "impostazioni-form.php";

$templateParams["action"] = $_GET["action"];

require 'template/base.php';
?>