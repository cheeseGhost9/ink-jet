
<div class="row">
    <div class="col-10 offset-1 col-md-7 mt-2">
        <form action="register.php" method="POST">
            <h2 class="text-center">Registrazione</h2>
            <?php if(isset($templateParams["erroreregistration"])): ?>
            <p class="text-center"><?php echo $templateParams["erroreregistration"]; ?></p>
            <?php endif; ?>
            <ul class="list-group">
                <li class="list-group-item">
                    <label for="nomeutente">Nome Utente:</label><input type="text" id="nomeutente" name="nomeutente" required/>
                </li>
                <li class="list-group-item">
                    <label for="datanascita">Data di Nascita:</label><input type="date" id="datanascita" name="datanascita" required/>
                </li>
                <li class="list-group-item">
                    <label for="email">E-mail:</label><input type="email" id="email" name="email" required/>
                </li>
                <li class="list-group-item">
                    <label for="password">Password:</label><input type="password" id="password" name="password" required/>
                </li>
                <li>
                    <input class="btn mt-2 text-center text-white" type="submit" name="submit" value="Registrati" />
                </li>
            </ul>
        </form>
    </div>
</div>