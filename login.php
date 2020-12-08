<?php
    session_start();
    if (isset($_SESSION["login"]) || $_COOKIE["login"]) {
        header("location: ./");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login_register.css">
    <title>CI | Login</title>
</head>
<body>
    <nav id="navbar"></nav>
    <div class="lr-zone">
        <div class="lr-panel">
            <h1>
                Login
            </h1>
            <div class="lr-form">
                <form action="scripts/php/efetua_login.php" method="POST">
                    <div class="lr-inputGroup">
                        <label for="l_user">Username/Email:</label>
                        <input type="text" name="l_user" id="l_user">
                    </div>
                    <div class="lr-inputGroup">
                        <label for="l_pwd">Password:</label>
                        <input type="password" name="l_pwd" id="l_pwd">
                        <a href="">Esqueci-me da password.</a>
                    </div>
                    <div class="lr-inputGroup">
                        <label for="l_keepLogin">Manter-me logado:
                           <input type="checkbox" name="l_keepLogin" id="l_keepLogin" value="keep">
                        </label>
                    </div>

                    <div class="lr-inputBtn">
                        <input type="submit" value="Login" name="loginBtn" id="loginBtn">
                    </div>
                </form>
            </div>
            <div class="lr-footer">
                Não possui uma conta?<br>
                <a href="register.php">Criar conta!</a>
            </div>
        </div>
    </div>
    
    <footer id="footer"></footer>
</body>
</html>