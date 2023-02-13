<?php
require_once 'bootstrap.php';

$result["list"] = $dbh->getFollowsByUserId($_GET["id"], $_GET["num_limit"], $_GET["row_offset"]);
for($i = 0; $i < count($result["list"]); $i++){
    if($result["list"][$i]["img_utente"] !== "" && $result["list"][$i]["img_utente"] !== null){
        $result["list"][$i]["img_utente"] = UPLOAD_DIR.$result["list"][$i]["img_utente"];
    }
}
$result["follows_list"] = $dbh->getFollowsByUserId($_SESSION["id_utente"]);
$result["id_utente"] = $_SESSION["id_utente"];

header('Content-Type: application/json');
echo json_encode($result);
?>