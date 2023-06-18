<?php
require_once 'bootstrap.php';

$result["list"] = $dbh->getUserFollow($_GET["id"], $_GET["choise"]);
for($i = 0; $i < count($result["list"]); $i++){
    if($result["list"][$i]["img_utente"] !== "" && $result["list"][$i]["img_utente"] !== null){
        $result["list"][$i]["img_utente"] = UPLOAD_DIR.$result["list"][$i]["img_utente"];
    }
}
$result["follows_list"] = $dbh->getUserFollow($_SESSION["id_utente"], "s");
$result["id_utente"] = $_SESSION["id_utente"];

header('Content-Type: application/json');
echo json_encode($result);
?>