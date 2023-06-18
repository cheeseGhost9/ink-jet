<?php
require_once 'bootstrap.php';

$id_utente;
if(isset($_GET["id_utente"])){
    $id_utente = $_GET["id_utente"];
} else {
    $id_utente = $_GET["id"];
}

// controlla se l'utente è seguito
if(count($dbh->checkFollow($id_utente, $_SESSION["id_utente"])) === 0){
    $result["you_follow"] = $dbh->insertFollow($id_utente, $_SESSION["id_utente"]);

    $msg = $_SESSION["nome_utente"] . " ha iniziato a seguirti.";
    $utente_seguito = $dbh->getUser($id_utente);
    $dbh->addNotification($utente_seguito[0]["id_utente"], $msg);

} else {
    $result["you_follow"] = !$dbh->deleteFollow($id_utente, $_SESSION["id_utente"]);
}

header('Content-Type: application/json');
echo json_encode($result);
?>