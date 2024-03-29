
<div class="row">
    <div class="col-10 offset-1 col-md-7 mt-2">
        <form action="processa-impostazioni.php" method="POST" enctype="multipart/form-data">
            <h2 class="text-center">Impostazioni</h2>
            <?php if(isset($_SESSION["errore"])): ?>
            <p class="text-center"><?php echo $_SESSION["errore"]; unset($_SESSION["errore"]); ?></p>
            <?php endif; ?>
            <ul class="list-group">
                <?php if($templateParams["action"] == 1): ?>
                    <p class="text-center">Compilare solo i campi che si desidera modificare</p>
                    <li class="list-group-item">
                        <label for="username">Nome Utente:</label><input type="text" id="username" name="username"/>
                    </li>
                    <li class="list-group-item">
                        <label for="img">Immagine</label><input type="file" name="img" id="img" />
                    </li>
                    <li class="list-group-item">
                        <label for="email">E-mail:</label><input type="email" id="email" name="email"/>
                    </li>
                    <li class="list-group-item">
                        <label for="confirm">Inserisci password per conferma:</label><input type="password" id="confirm" name="confirm" required/>
                    </li>
                <?php endif; ?>
                <?php if($templateParams["action"] == 2): ?>
                    <li class="list-group-item">
                        <label for="password">Vecchia password:</label><input type="password" id="old_password" name="old" required/>
                    </li>
                    <li class="list-group-item">
                        <label for="password">Nuova password:</label><input type="password" id="password" name="new" required/>
                    </li>
                    <li class="list-group-item">
                        <label for="confirm">Reinserisci la nuova password:</label><input type="password" id="confirm" name="confirm" required/>
                    </li>
                <?php endif; ?>
                <input type="submit" name="submit" value="Conferma" class="btn" />
                <a href="profilo.php?id=<?php echo $_SESSION["id_utente"] ?>" class="btn">Annulla</a>
            </ul>
            <input type="hidden" name="action" value="<?php echo $templateParams["action"]; ?>" class="button" />
        </form>
    </div>
</div>