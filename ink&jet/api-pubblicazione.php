<?php
require_once 'bootstrap.php';

$result["post"] = $dbh->getRecentFollowedPosts($_SESSION["id_utente"], $_GET["num_posts"], $_GET["row_offset"]);

if($result["post"] > 0){
    for($i = 0; $i < count($result["post"]); $i++){
        $result["post"][$i]["img_pubblicazione"] = UPLOAD_DIR.$result["post"][$i]["img_pubblicazione"];
        $result["post"][$i]["img_utente"] = UPLOAD_DIR.$result["post"][$i]["img_utente"];
    }
    $result["num"] = count($dbh->getFollowedPosts($_SESSION["id_utente"]));
}
header('Content-Type: application/json');
echo json_encode($result);
?>