<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "post";
$templateParams["nome"] = "singolo-post.php";

if(isset($_POST["testo_commento"])){
    $dbh->addComment($_POST["testo_commento"], date("Y-m-d"), $_SESSION["id_utente"], $_POST["id_post"]);
}

if(isset($_GET["post"]) && $_GET["post"] != "" && $_GET["post"] != NULL){
    $templateParams["post"] = $dbh->getPostAndUserById($_GET["post"]);
    $templateParams["commenti"] = $dbh->getCommentsAndUserByPostId($_GET["post"]);
}

require 'template/base.php';
?>