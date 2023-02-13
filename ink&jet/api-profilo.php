<?php
require_once 'bootstrap.php';

$result["user_attuale"] = false;

if($_GET["id"] == $_SESSION["id_utente"]){
    $result["user_attuale"] = true;
} else {
    $result["you_follow"] = true;
    if(count($dbh->checkFollow($_GET["id"], $_SESSION["id_utente"])) === 0){
        $result["you_follow"] = false;
    }
}

$result["dati_utente"] = $dbh->getUserById($_GET["id"]);
$result["dati_utente"][0]["img_utente"] = UPLOAD_DIR.$result["dati_utente"][0]["img_utente"];
$result["follows"] = count($dbh->getFollowsByUserId($_GET["id"]));
$result["followers"] = count($dbh->getFollowersByUserId($_GET["id"]));
$result["post"] = count($dbh->getPostByUserId($_GET["id"]));

header('Content-Type: application/json');
echo json_encode($result);
?>