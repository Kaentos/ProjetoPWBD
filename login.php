<?php
    session_start();
    if (isset($_SESSION["login"]) || $_COOKIE["login"]) {
        header("location: ./");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="assets/js/login_register.js"></script>
    <link rel="stylesheet" href="assets/css/login_register.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <?php
        if (isset($_SESSION["badLogin"])) {
            echo "<script>window.onload=function(){badLogin('".$_SESSION["badLogin"]."')}</script>";
            unset($_SESSION["badLogin"]);
        }
    ?>
    <title>CI | Login</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>

    <div class="l-zone">
        <div class="l-panel">
            <h1>
                Login
            </h1>
            <div class="lr-warning" id="badWarning">
                ERROR
            </div>
            <div class="l-form">
                <form action="scripts/php/efetua_login.php" method="POST">
                    <div class="l-inputGroup">
                        <label for="l_user">Nome de utilizador ou Email:</label>
                        <input type="text" name="l_user" id="l_user" placeholder="mail@dominio.pt">
                    </div>
                    <div class="l-inputGroup">
                        <label for="l_pwd">Palavra-passe:</label>
                        <input type="password" name="l_pwd" id="l_pwd">
                        <a href="">Esqueci-me da palavra-passe</a>
                    </div>
                    <div class="l-inputGroup">
                        <label for="l_keepLogin">Manter-me logado:
                           <input class="custom-checkbox" type="checkbox" name="l_keepLogin" id="l_keepLogin" value="keep">
                        </label>
                    </div>

                    <div class="lr-inputBtn">
                        <input type="submit" value="Entrar" name="loginBtn" id="loginBtn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <footer id="footer"></footer>
</body>
</html>