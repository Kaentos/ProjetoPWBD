<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    $query = "
        SELECT *
        FROM TipoUtilizador
        ORDER BY nome;
    ";        
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    if ($stmt -> rowCount() == 0) {
        die("Não existem tipos de utilizadores");
    }
    $userTypes = $stmt -> fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/register.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/login_register.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <script src="/ProjetoPWBD/assets/js/login_register.js"></script>
    <link rel="icon" href="/ProjetoPWBD/assets/img/icon.png">
    
    <script>
        window.onload = function() {
            activateLiveCheckRegister();
            <?php
                if (isset($_SESSION["badRegister"])) {
                    echo "badRegister('".$_SESSION["badRegister"]["error"]."', ".$_SESSION["badRegister"]["code"].");";
                    echo "addValuesToRegister(".json_encode($_SESSION["badRegister"]["user"]).");";
                    unset($_SESSION["badRegister"]);    
                }
            ?>
        }
    </script>
    <title>CI | Registar</title>
</head>
<body>
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/navbar.php");
    ?>
    <div class="r-zone">
        <div class="lr-warning" id="badWarning">
            
        </div>
        <div class="r-panel">
            <h1>
                Adicionar utilizador
            </h1>
            <div class="r-form">
                <form action="/ProjetoPWBD/scripts/php/efetua_registo.php" method="POST">
                    <div class="r-form-category">
                        Informação da conta
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_username">
                            Nome de Utilizador<sup>*</sup>
                        </label>
                        <div class="r-inputGroup-input">
                            <input class="type-input" type="text" name="r_username" id="r_username" autofocus required>
                            <span>Tamanho: 4-16 caracteres</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_email">
                            Email<sup>*</sup>
                        </label>
                        <div class="r-inputGroup-input">
                            <input class="type-input" type="email" name="r_email" id="r_email" required>
                            <span>Tamanho: 6-128 caracteres</span>
                        </div>
                    </div>

                    <div class="r-inputGroup">
                        <label for="r_pwd">
                            Palavra-passe<sup>*</sup>
                        </label>
                        <div class="r-inputGroup-input">
                            <input class="type-input" type="password" name="r_pwd" id="r_pwd" required>
                            <span>Regras: 4-64 caracteres, 1 caracter maiúsculo, 1 caracter minúsculo, 1 número.</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_pwd2">
                            Confirmar palavra-passe<sup>*</sup>
                        </label>
                        <div class="r-inputGroup-input">
                            <input class="type-input" type="password" name="r_pwd2" id="r_pwd2" required>
                        </div>
                    </div>

                    <div class="r-inputGroup">
                        <label for="r_userType">
                            Tipo utilizador<sup>*</sup>
                        </label>
                        <div class="r-inputGroup-input">
                            <select id="r_userType" name="r_userType">
                                <?php
                                    foreach ($userTypes as $type) {
                                        // Se o tipo for apagado não coloca na lista
                                        if ($type["id"] == USER_TYPE_DELETED) {
                                            continue;
                                        }
                                        if ($type["id"] == USER_TYPE_CLIENT) {
                                            echo "
                                                <option value='". $type["id"] ."' selected>
                                                    ". $type["nome"] ."
                                                </option>
                                            ";
                                        } else {
                                            echo "
                                                <option value='". $type["id"] ."'>
                                                    ". $type["nome"] ."
                                                </option>
                                            ";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>



                    <div class="r-form-category">
                        Dados pessoais:
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_name">
                            Primeiro e último nome<sup>*</sup>
                        </label>
                        <div class="r-inputGroup-input">
                            <input class="type-input" type="text" name="r_name" id="r_name" required>
                            <span>Tamanho: 6-64 caracteres. Sem pontuação.</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_mobile">
                            Nº telemóvel<sup>*</sup>
                        </label>
                        <div class="r-inputGroup-input">
                            <input class="type-input" type="number" name="r_mobile" id="r_mobile" required>
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>
                    <div class="r-inputGroup">
                        <label for="r_tel">
                            Nº telefone
                        </label>
                        <div class="r-inputGroup-input">
                            <input class="type-input" type="number" name="r_tel" id="r_tel">
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>

                    <div class="lr-inputBtn">
                        <input type="submit" value="Adicionar" name="registerBtn" id="registerBtn">
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