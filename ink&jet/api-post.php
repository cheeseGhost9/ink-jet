<?php
require_once 'bootstrap.php';

    if($_GET["source"] === "home"){
        // ottiene i post degli utenti seguiti
        $result["post"] = $dbh->getPostOfFollowedUsers($_SESSION["id_utente"]);
        if($result["post"] > 0){
            for($i = 0; $i < count($result["post"]); $i++){
                $result["post"][$i]["img_post"] = UPLOAD_DIR.$result["post"][$i]["img_post"];
                $result["post"][$i]["img_utente"] = UPLOAD_DIR.$result["post"][$i]["img_utente"];
            }
        }
    } elseif($_GET["source"] === "profile"){
        // ottiene i post
        $result["owner"] = false;
        $result["post"] = $dbh->getUserPost($_GET["id"]);
        for($i = 0; $i < count($result["post"]); $i++){
            if($result["post"][$i]["img_post"] !== "" && $result["post"][$i]["img_post"] !== null){
                $result["post"][$i]["img_post"] = UPLOAD_DIR.$result["post"][$i]["img_post"];
            }
        }

        // controlla se l'utente è proprietario dei post
        if($_GET["id"] == $_SESSION["id_utente"]){
            $result["owner"] = true;
        }
    }

header('Content-Type: application/json');
echo json_encode($result);
?>
