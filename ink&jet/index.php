<?php
require_once 'bootstrap.php';

if(!isUserLoggedIn()){
    header("location: login.php");
}

$templateParams["titolo"] = "index";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js","js/index.js");

require 'template/base.php';
?>