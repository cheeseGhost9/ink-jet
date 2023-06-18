<?php
require_once 'bootstrap.php';

if(isset($_POST["testo_commento"])){
    $dbh->insertComment($_POST["testo_commento"], date("Y-m-d"), $_SESSION["id_utente"], $_POST["id_post"]);
}

if(isset($_GET["post"]) && $_GET["post"] != "" && $_GET["post"] != NULL){
    $templateParams["post"] = $dbh->getPostAndUser($_GET["post"]);
    $templateParams["commenti"] = $dbh->getCommentsAndUser($_GET["post"]);
}

$templateParams["titolo"] = "post";
$templateParams["nome"] = "singolo-post.php";

require 'template/base.php';
?>