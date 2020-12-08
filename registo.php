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
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="assets/css/login_register.css">
    <script src="assets/js/login_register.js"></script>
    <?php
        if (isset($_SESSION["badRegister"])) {
            echo "<script>window.onload=function(){badRegister('".$_SESSION["badRegister"]."')}</script>";
            unset($_SESSION["badRegister"]);
        }
    ?>
    <title>CI | Registar</title>
</head>
<body>
    <nav id="navbar"></nav>
    <div class="r-zone">
        <div class="r-panel">
            <h1>
                Registar
            </h1>
            <div class="lr-warning" id="badWarning">
                ERROR
            </div>
            <div class="r-form">
                <form action="scripts/php/efetua_login.php" method="POST">
                    <div class="r-inputGroup-of2">
                        <label for="r_name">Primeiro e último nome: *</label>
                        <input type="text" name="r_name" id="r_name" required>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_user">Username: *</label>
                        <input type="text" name="r_user" id="r_user" required>
                        <span>Tamanho: 6-16 caracteres.</span>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_email">Email: *</label>
                        <input type="email" name="r_email" id="r_email" required>
                        <span>Tamanho: 6-128 caracteres.</span>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_pwd">Password: *</label>
                        <input type="password" name="r_pwd" id="r_pwd" required>
                        <span>Tamanho: 6-64 caracteres.</span>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_pwd2">Confirmar password: *</label>
                        <input type="password" name="r_pwd2" id="r_pwd2" required>
                    </div>
                    <div class="r-inputGroup-of1">
                        <label for="r_address">Morada: *</label>
                        <input type="text" name="r_address" id="r_address" required>
                        <span>Tamanho: 6-128 caracteres.</span>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_cc">Nº cartão cidadão / BI: *</label>
                        <input type="number" name="r_cc" id="r_cc" required>
                        <span>Tamanho: 8 digitos.</span>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_date">Data Nascimento: *</label>
                        <input type="date" name="r_date" id="r_date" required>
                        <span>Precisa de ter 18 anos.</span>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_mobile">Nº telemóvel: *</label>
                        <input type="number" name="r_mobile" id="r_mobile" required>
                        <span>Tamanho: 9 digitos.</span>
                    </div>
                    <div class="r-inputGroup-of3">
                        <label for="r_tel">Nº telefone:</label>
                        <input type="number" name="r_tel" id="r_tel">
                        <span>Tamanho: 9 digitos.</span>
                    </div>

                    <div class="lr-inputBtn">
                        <input type="submit" value="Registar" name="registerBtn" id="registerBtn">
                    </div>
                </form>
            </div>
            <div class="lr-footer">
                Já possuir conta?<br>
                <a href="login.php">Efetuar login!</a>
            </div>
        </div>
    </div>
    
    <footer id="footer"></footer>
</body>
</html>