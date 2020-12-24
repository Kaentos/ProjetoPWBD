<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfLoggedWithGoto();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="assets/js/login_register.js"></script>
    <link rel="stylesheet" href="assets/css/login_register.css">
    <link rel="stylesheet" href="assets/css/navbar_footer.css">
    <script>
        window.onload = function() {
            activateLiveCheckLogin();
            <?php
                if (isset($_SESSION["badLogin"])) {
                    echo "badLogin('".$_SESSION["badLogin"]."')";
                    unset($_SESSION["badLogin"]);
                }
            ?>
        }
    </script>
    
    <title>CI | Login</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>

    <div class="l-zone">
        <div class="lr-warning" id="badWarning">
            
        </div>
        <div class="l-panel">
            <h1>
                Login
            </h1>
            
            <div class="l-form">
                <form action="scripts/php/efetua_login.php" method="POST">
                    <div class="l-inputGroup">
                        <label for="l_user">Nome de utilizador ou Email:</label>
                        <input class="type-input" type="text" name="l_user" id="l_user" autofocus required>
                    </div>
                    <div class="l-inputGroup">
                        <label for="l_pwd">Palavra-passe:</label>
                        <input class="type-input" type="password" name="l_pwd" id="l_pwd" required>
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
    
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>