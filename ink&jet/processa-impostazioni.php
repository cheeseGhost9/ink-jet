<?php
require_once 'bootstrap.php';

if($_POST["action"] == 1){
    $msg = "";
    $new_username = trim($_POST["username"]);
    $new_email = trim($_POST["email"]);
    $password = hash('sha256', $_POST["confirm"]);
    $test = $dbh->checkUser($new_email, "", $new_username);
    $username = $_SESSION["nome_utente"];
    $email = $_SESSION["email"];
    $img = $_SESSION["img_utente"];

    // controlla se la password è corretta
    if(count($dbh->checkUser($_SESSION["email"], $password)) === 0){
        $msg .= "Password errata. ";

    } else {
        // aggiorna il nome utente
        if($new_username !== "") {
            if(isset($test[0]) && $test[0]["nome_utente"] === $new_username){
                $msg .= "Il nome utente inserito e' usato da un altro account. ";
            } else {
                $username = $new_username;
            }
        }

        // aggiorna l'immagine del profilo
        if($_FILES["img"]["size"] !== 0){
            list($result_img, $new_img) = uploadImage(UPLOAD_DIR, $_FILES["img"]);
            if($result_img){
                $img = $new_img;
            } else {
                $msg .= $new_img;
            }
        }

        // aggiorna l'email
        if($new_email !== ""){
            if(isset($test[0]) && $test[0]["email"] === $new_email) {
                $msg .= "L'email inserita e' usata da un altro account. ";
            } else {
                $email = $new_email;
            }
        }

        if(strlen($msg) === 0){
            $dbh->updateUser($_SESSION["id_utente"], $username, $email, $img);
            registerLoggedUser($dbh->checkUser($email, $password)[0]);
        }
    }

    if(strlen($msg) === 0){
        header("location: profilo.php");
    } else {
        $_SESSION["errore"] = $msg;
        header("location: impostazioni.php?action=1");
    }
}

if($_POST["action"] == 2){

    $old = hash('sha256', $_POST["old"]);
    $new = $_POST["new"];
    $confirm = $_POST["confirm"];
    
    // controlla se la vecchia password è corretta
    if(count($dbh->checkUser($_SESSION["email"], $old)) === 0){
        $_SESSION["errore"] = "La vecchia password è errata.";
        header("location: impostazioni.php?action=2");
    } else {
        // controlla se la nuova password e quella di conferma combaciano
        if($new === $confirm){
            $new = hash('sha256', $new);
            $dbh->updatePassword($_SESSION["id_utente"], $new);
            header("location: profilo.php");
        } else {
            $_SESSION["errore"] = "La nuova password e quella di conferma non combaciano.";
            header("location: impostazioni.php?action=2");
        }
    }
}

?>