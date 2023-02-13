<?php
require_once 'bootstrap.php';

if($_POST["action"] == 1){
    //Inserisco post
    $testo_pubblicazione = htmlspecialchars($_POST["testo_pubblicazione"]);
    $data_pubblicazione = date("Y-m-d");
    $utente = $_SESSION["id_utente"];
    list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["img_pubblicazione"]);
    $img_pubblicazione = $msg;
    $dbh->insertPost($testo_pubblicazione, $data_pubblicazione, $img_pubblicazione, $utente);
    header("location: profilo.php");
}
if($_POST["action"] == 2){
    //modifico post
    $testo_pubblicazione = htmlspecialchars($_POST["testo_pubblicazione"]);
    $id_pubblicazione = $_POST["id_pubblicazione"];
    $utente = $_SESSION["id_utente"];
    if(isset($_FILES["img_pubblicazione"]) && strlen($_FILES["img_pubblicazione"]["name"])>0){
        list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["img_pubblicazione"]);
        if($result == 0){
            header("location: profilo.php");
        }
        $img_pubblicazione = $msg;
    }
    else{
        $img_pubblicazione = $_POST["oldimg"];
    }
    $dbh->updatePostOfUser($id_pubblicazione, $testo_pubblicazione, $img_pubblicazione);
    $msg = "Post aggiornato correttamente.";
    header("location: profilo.php");
}

if($_POST["action"] == 3){
    //elimino post
    $id_pubblicazione = $_POST["id_pubblicazione"];
    $utente = $_SESSION["id_utente"];
    $dbh->deleteCommentsOfPost($id_pubblicazione);
    $dbh->deletePostOfUser($id_pubblicazione, $utente);
    $msg = "Post eliminato correttamente!";
    header("location: profilo.php");
}

?>