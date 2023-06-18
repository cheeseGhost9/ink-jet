<?php
require_once 'bootstrap.php';

if(!isUserLoggedIn()){
    header("location: login.php");
}

$templateParams["titolo"] = "home";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js","js/home.js");

require 'template/base.php';
?>