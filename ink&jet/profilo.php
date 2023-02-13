<?php
require_once 'bootstrap.php';

if(!isUserLoggedIn()){
    header("location: login.php");
}

if(!isset($_GET["id"])){
    header("location: profilo.php?id=" . $_SESSION["id_utente"]);
}

$templateParams["titolo"] = "profilo";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js","js/profilo.js");

require 'template/base.php';
?>