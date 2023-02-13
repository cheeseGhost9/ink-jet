<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
    <div class="container-fluid p-0 overflow-hidden">

        <div class="row">
            <div class="col-12">
                <header class="py-3 text-white">
                    <h1 class="font-monospace text-center">Ink & Jet</h1>
                </header>   
            </div>   
        </div>

        <?php if(isUserLoggedIn()): ?>
        <div class="navigazione">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills flex-md-column">
                        <li class="nav-item col-6 col-md-12">
                            <a class="nav-link mt-2 mx-2 text-center btn" href="index.php">Home</a>
                        </li>
                        <li class="nav-item col-6 col-md-12">
                            <a class="nav-link mt-2 mx-2 text-center btn" href="profilo.php">Profilo</a>
                        </li>
                        <li class="nav-item col-6 col-md-12">
                            <a class="nav-link mt-2 mx-2 text-center btn" href="gestisci-post.php" onclick="createCookieAzione(1)">NUOVO POST</a>
                        </li>
                        <li class="nav-item col-6 col-md-12">
                            <a class="nav-link mt-2 mx-2 text-center btn" href="logout.php">Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="navigazione">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills flex-md-column">
                        <li class="nav-item col-6 col-md-12">
                            <a class="nav-link mt-2 mx-2 text-center btn" href="login.php">Login</a>
                        </li>
                        <li class="nav-item col-6 col-md-12">
                            <a class="nav-link mt-2 mx-2 text-center btn" href="register.php">Registrati</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="main">
        <?php
        if(isset($templateParams["nome"])){
            require($templateParams["nome"]);
        }
        ?>
        </div>

        <div class="row">
            <div class="col-12">
                    <footer class="py-3 text-white float-bottom">
                        <p class="font-monospace text-center text-white">Ink & Jet</p>
                    </footer>   
            </div>   
        </div>

    </div>

    <script src="js/setCookieScript.js"></script>
    <?php
    if(isset($templateParams["js"])):
        foreach($templateParams["js"] as $script):
    ?>
        <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>