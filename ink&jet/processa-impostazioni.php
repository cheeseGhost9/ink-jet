<?php
require_once 'bootstrap.php';

if($_POST["action"] == 1){
    $msg = "";
    $nome = trim($_POST["nomeutente"]);
    $email = trim($_POST["email"]);
    $password = hash('sha256', $_POST["password_confirm"]);

    // controllo se la password è corretta
    if(count($dbh->checkPassword($_SESSION["id_utente"], $password)) === 0){
        $msg .= "Password errata. ";

    } else {
        // aggiorna il nome utente
        if($nome !== "") {
            if(count($dbh->checkIfUsernameExists($nome)) !== 0){
                $msg .= "Il nome utente inserito e' usato da un altro account. ";
            } else {
                $dbh->updateUserName($_SESSION["id_utente"], $nome);
            }
        }

        // aggiorna l'immagine del profilo
        if($_FILES["imgprofilo"]["size"] !== 0){
            list($result_img, $imgprofilo) = uploadImage(UPLOAD_DIR, $_FILES["imgprofilo"]);
            if($result_img){
                $dbh->updateUserImg($_SESSION["id_utente"], $imgprofilo);
            } else {
                $msg .= $imgprofilo;
            }
        }

        // aggiorna l'email
        if($email !== ""){
            if(count($dbh->checkIfEmailExists($email)) !== 0) {
                $msg .= "L'email inserita e' usata da un altro account. ";
            } else {
                $dbh->updateUserEmail($_SESSION["id_utente"], $email);
            }
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

    $old_password = hash('sha256', $_POST["old_password"]);
    $new_password = $_POST["password"];
    $confirm_password = $_POST["password_confirm"];
    

    if(count($dbh->checkPassword($_SESSION["id_utente"], $old_password)) === 0){
        $_SESSION["errore"] = "La vecchia password è errata.";
        header("location: impostazioni.php?action=2");
    } else {
        if($new_password === $confirm_password){
            $new_password = hash('sha256', $new_password);
            $dbh->updateUserPassword($_SESSION["id_utente"], $new_password);
            header("location: profilo.php");
        } else {
            $_SESSION["errore"] = "La nuova password non combacia.";
            header("location: impostazioni.php?action=2");
        }
    }
}


?>