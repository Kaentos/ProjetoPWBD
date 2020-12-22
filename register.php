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
    <link rel="stylesheet" href="assets/css/navbar.css">
    <script src="assets/js/login_register.js"></script>
    
    <script>
        window.onload = function() {
            setDataNascLimits();
            <?php
                if (isset($_SESSION["badRegister"])) {
                    echo "badRegister('".$_SESSION["badRegister"][0]."')";
                    unset($_SESSION["badRegister"]);
                }
            ?>
        }
    </script>
    <title>CI | Registar</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="r-zone">
        <div class="r-panel">
            <h1>
                Registar
            </h1>
            <div class="lr-warning" id="badWarning">
                ERROR
            </div>
            <div class="r-form">
                <form action="scripts/php/efetua_registo.php" method="POST">
                    <div class="r-form-category">
                        Informação da conta
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_username">
                            Nome de Utilizador: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="text" name="r_username" id="r_username" >
                            <span>Tamanho: 4-16 caracteres.</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_email">Email: *</label>
                        <div class="r-inputGroup-input">
                            <input type="email" name="r_email" id="r_email" >
                            <span>Tamanho: 6-128 caracteres.</span>
                        </div>
                    </div>

                    <div class="r-inputGroup">
                        <label for="r_pwd">
                            Palavra-passe: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="password" name="r_pwd" id="r_pwd" >
                            <span>Regras: 6-64 caracteres, 1 caracter maiúsculo, 1 caracter minúsculo, 1 número.</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_pwd2">
                            Confirmar palavra-passe: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="password" name="r_pwd2" id="r_pwd2" >
                        </div>
                    </div>
                    


                    <div class="r-form-category">
                        Dados pessoais:
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_name">
                            Primeiro e último nome: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="text" name="r_name" id="r_name" >
                            <span>Tamanho: 6-64 caracteres.</span>
                        </div>
                    </div>
                    <!-- <div class="r-inputGroup">
                        <label for="r_address">
                            Morada: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="text" name="r_address" id="r_address" required>
                            <span>Tamanho: 6-128 caracteres.</span>
                        </div>
                    </div> -->
                    <div class="r-inputGroup">
                        <label for="r_cc">
                            Nº cartão cidadão / BI: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="number" name="r_cc" id="r_cc" >
                            <span>Tamanho: 8 digitos.</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_date">
                            Data Nascimento: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="date" name="r_date" id="r_date" >
                            <span>Precisa de ser maior de idade (+18 anos).</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_mobile">
                            Nº telemóvel: *
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="number" name="r_mobile" id="r_mobile" >
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_tel">
                            Nº telefone:
                        </label>
                        <div class="r-inputGroup-input">
                            <input type="number" name="r_tel" id="r_tel">
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>

                    <div class="lr-inputBtn">
                        <input type="submit" value="Registar" name="registerBtn" id="registerBtn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <footer id="footer"></footer>
</body>
</html>