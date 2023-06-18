<?php
require_once 'bootstrap.php';

if($_POST["action"] == 1){
    //Inserisco post
    $testo_post = htmlspecialchars($_POST["testo_post"]);
    $data_post = date("Y-m-d");
    $utente = $_SESSION["id_utente"];
    list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["img_post"]);
    $img_post = $msg;
    $dbh->insertPost($testo_post, $data_post, $img_post, $utente);

    $msg = $_SESSION["nome_utente"] . " ha pubblicato un nuovo post.";
    $followers = $dbh->getUserFollow($_SESSION["id_utente"], "ers");
    foreach($followers as $utente){
        $dbh->addNotification($utente["id_utente"], $msg);
    }

    header("location: profilo.php");
}
if($_POST["action"] == 2){
    //modifico post
    $testo_post = htmlspecialchars($_POST["testo_post"]);
    $id_post = $_POST["id_post"];
    $utente = $_SESSION["id_utente"];
    if(isset($_FILES["img_post"]) && strlen($_FILES["img_post"]["name"])>0){
        list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["img_post"]);
        if($result == 0){
            header("location: profilo.php");
        }
        $img_post = $msg;
    }
    else{
        $img_post = $_POST["oldimg"];
    }
    $dbh->updatePost($id_post, $testo_post, $img_post);
    $msg = "Post aggiornato correttamente.";
    header("location: profilo.php");
}

if($_POST["action"] == 3){
    //elimino post
    $id_post = $_POST["id_post"];
    $utente = $_SESSION["id_utente"];
    $dbh->deleteCommentsOfPost($id_post);
    $dbh->deletePostOfUser($id_post, $utente);
    $msg = "Post eliminato correttamente!";
    header("location: profilo.php");
}

?>