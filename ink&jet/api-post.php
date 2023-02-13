<?php
require_once 'bootstrap.php';

$result["proprietario"] = false;
$result["post"] = $dbh->getPostByUserId($_GET["id"], $_GET["num_limit"], $_GET["row_offset"]);
for($i = 0; $i < count($result["post"]); $i++){
    if($result["post"][$i]["img_pubblicazione"] !== "" && $result["post"][$i]["img_pubblicazione"] !== null){
        $result["post"][$i]["img_pubblicazione"] = UPLOAD_DIR.$result["post"][$i]["img_pubblicazione"];
    }
}

// controlla se l'utente è proprietario dei post
if($_GET["id"] == $_SESSION["id_utente"]){
    $result["proprietario"] = true;
}

header('Content-Type: application/json');
echo json_encode($result);
?>