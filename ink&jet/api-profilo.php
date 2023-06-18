<?php
require_once 'bootstrap.php';

$result["current_user"] = false;

// controlla se il profilo visualizzato è dell'utente loggato
if($_GET["id"] == $_SESSION["id_utente"]){
    $result["current_user"] = true;
} else {
    // controlla se l'utente è seguito
    $result["you_follow"] = true;
    if(count($dbh->checkFollow($_GET["id"], $_SESSION["id_utente"])) === 0){
        $result["you_follow"] = false;
    }
}

$result["user_data"] = $dbh->getUser($_GET["id"]);
$result["user_data"][0]["img_utente"] = UPLOAD_DIR.$result["user_data"][0]["img_utente"];
$result["follows"] = count($dbh->getUserFollow($_GET["id"], "s"));
$result["followers"] = count($dbh->getUserFollow($_GET["id"], "ers"));
$result["post"] = count($dbh->getUserPost($_GET["id"]));

header('Content-Type: application/json');
echo json_encode($result);

?>