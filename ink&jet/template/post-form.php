<?php
    $post = $templateParams["post"]; 
    $azione = getAction($templateParams["azione"]);
    if(isset($_COOKIE["azione"])){
        setcookie("azione", "", time() - 3600, "\\");
    }
?>
<div class="row">
    <div class="col-10 offset-1 col-md-7 mt-2">
        <form action="processa-post.php" method="POST" enctype="multipart/form-data">
            <h2 class="text-center">Gestisci Post</h2>
            <?php if($post==null): ?>
            <p>Post non trovato</p>
            <?php else: ?>
            <ul>
                <li>
                    <?php if(isset($post["testo_post"])): ?>
                    <label for="testo_post">Testo:</label><textarea id="testo_post" name="testo_post"><?php echo $post["testo_post"]; ?></textarea>
                    <?php else: ?>
                    <label for="testo_post">Testo:</label><textarea id="testo_post" name="testo_post"></textarea>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if($templateParams["azione"]!=3): ?>
                    <label for="img_post">Immagine</label><input type="file" name="img_post" id="img_post" />
                    <?php endif; ?>
                    <?php if($templateParams["azione"]!=1 && $post["img_post"] != NULL ): ?>
                    <img src="<?php echo UPLOAD_DIR.$post["img_post"]; ?>" alt="" />
                    <?php endif; ?>
                </li>
                <li>
                    <input type="submit" name="submit" value="<?php echo $azione; ?> post" class="btn"/>
                    <a href="profilo.php" class="btn">Annulla</a>
                </li>
            </ul>
                <?php if($templateParams["azione"]!=1): ?>
                <input type="hidden" name="id_post" value="<?php echo $post["id_post"]; ?>" />
                <input type="hidden" name="oldimg" value="<?php echo $post["img_post"]; ?>" />
                <?php endif;?>

                <input type="hidden" name="action" value="<?php echo $templateParams["azione"]; ?>" />
            <?php endif;?>
        </form>
    </div>
</div>