<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfNotLoggedWithGoto();

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");   
    
    $query = "
        SELECT *
        FROM utilizador
        WHERE id = :id;
    ";
    $stmt = $dbo -> prepare($query);
    $idUser = LOGIN_DATA["id"];
    $stmt -> bindParam("id", $idUser);
    $stmt -> execute();
    if ($stmt -> rowCount() == 1) {
        $user = $stmt -> fetch();
        unset($idUser);
    } else {
        header("location: logout.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/mydata.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/login_register.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <script src="/ProjetoPWBD/assets/js/mydata.js"></script>
    
    <script>
        window.onload = function() {
            activateLiveCheckMyData();
            <?php
                if (isset($_SESSION["badMyData"])) {
                    echo "badMyData(".$_SESSION["badMyData"]["code"].", '".$_SESSION["badMyData"]["reason"]."');";
                    unset($_SESSION["badMyData"]);    
                }
                if (isset($_SESSION["message"])) {
                    echo "showMessage(".json_encode($_SESSION["message"]).");";
                    unset($_SESSION["message"]);
                }

                echo "showInfoMyDataUser(".json_encode($user).");"
            ?>
        }
    </script>
    <title>CI | Meus dados</title>
</head>
<body>
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/navbar.php");
    ?>
    <div class="md-zone">
        <div class="md-warning" id="badWarning">
            
        </div>
        <div class="md-panel">
            <h1>
                Meus dados / Alterar dados
            </h1>
            <div class="md-form">
                <form action="/ProjetoPWBD/scripts/php/change_my_data.php" method="POST">
                    <div class="md-form-category">
                        Informação da conta
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_username">
                            Nome de Utilizador<sup>*</sup>
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="text" name="md_username" id="md_username" required>
                            <span>Tamanho: 4-16 caracteres</span>
                        </div>
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_email">
                            Email<sup>*</sup>
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="email" name="md_email" id="md_email" required>
                            <span>Tamanho: 6-128 caracteres</span>
                        </div>
                    </div>

                    <div class="md-inputGroup">
                        <label for="md_pwd">
                            Nova palavra-passe
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="password" name="md_pwd" id="md_pwd">
                            <span>Regras: 4-64 caracteres, 1 caracter maiúsculo, 1 caracter minúsculo, 1 número.</span>
                        </div>
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_pwd2">
                            Confirmar palavra-passe
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="password" name="md_pwd2" id="md_pwd2">
                        </div>
                    </div>


                    <div class="md-form-category">
                        Dados pessoais:
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_name">
                            Primeiro e último nome<sup>*</sup>
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="text" name="md_name" id="md_name" required>
                            <span>Tamanho: 6-64 caracteres. Sem pontuação.</span>
                        </div>
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_mobile">
                            Nº telemóvel<sup>*</sup>
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="number" name="md_mobile" id="md_mobile" required>
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_tel">
                            Nº telefone
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="number" name="md_tel" id="md_tel">
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>

                    <div class="md-form-category">
                        Confirmar alteração:
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_pwd">
                            Palavra-passe atual<sup>*</sup>
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" type="password" name="md_cPwd" id="md_cPwd">
                        </div>
                    </div>

                    <div class="md-inputBtn">
                        <input type="submit" value="Alterar" name="editBtn" id="editBtn">
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