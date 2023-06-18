
<?php if(!isset($templateParams["post"]) || count($templateParams["post"]) == 0): ?>
<div class="row">
    <div class="col-10 offset-1 col-md-7 mt-2 post">
        <article>
            <p>Il post non esiste.</p>
        </article>
    </div>
</div>
<?php else:
        $post = $templateParams["post"][0];
        $commenti = $templateParams["commenti"];
?>

<div class="row">
    <div class="col-10 offset-1 col-md-7 my-2 post">
        <article>
            <header>
                    <div class="row mb-2">
                        <img src="<?php echo UPLOAD_DIR.$post["img_utente"]; ?>" alt="" class="col-3"/>
                        <h3 class="col-3"><a href="profilo.php?id=<?php echo $post["id_utente"]; ?>" class="btn"><?php echo $post["nome_utente"]; ?></a></h3>
                    </div>
            </header>
            <section>
                <?php if($post["img_post"] != NULL): ?>
                    <img src="<?php echo UPLOAD_DIR.$post["img_post"]; ?>" alt="" />
                <?php endif; ?>
                <?php if($post["testo_post"] != "" && $post["testo_post"] != NULL): ?>
                    <p class="post_text text-justify"><?php echo $post["testo_post"]; ?></p>
                <?php endif; ?>
            </section>
        </article>
    </div>
</div>

<div class="row">
    <div class="col-10 offset-1 col-md-7 mt-2">
        <form action="post.php?post=<?php echo $post["id_post"]; ?>" method="POST">
            <label for="testo_commento">Scrivi commento:</label>
            <textarea id="testo_commento" name="testo_commento" required></textarea>
            <input type="hidden" name="id_post" value="<?php echo $post["id_post"]; ?>" />
            <input type="submit" name="submit" value="Commenta" class="btn" />
        </form>
    </div>
</div>

<?php
    if(count($commenti) > 0)
        foreach($commenti as $commento):
?>
    <div class="row">
        <div class="col-10 offset-1 col-md-7 mt-2 post">
            <article>
                <header>
                    <div class="row mb-2">
                        <img src="<?php echo UPLOAD_DIR.$commento["img_utente"]; ?>" alt="" class="col-3"/>
                        <h4 class="col-3"><a href="profilo.php?id=<?php echo $commento["id_utente"]; ?>" class="btn"><?php echo $commento["nome_utente"]; ?></a></h4>
                    </div>
                </header>
                <section>
                    <p class="post_text text-justify"><?php echo $commento["testo_commento"]; ?></p>
                </section>
            </article>
        </div>
    </div>
<?php endforeach; ?>

<?php endif; ?>