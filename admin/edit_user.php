<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    if (isset($_GET["id"])) {
        $query = "
            SELECT u.id, u.username, u.email, tu.id AS tipoId, tu.nome AS tipoNome, u.nome, u.telemovel, u.telefone, u.isActive, u.isDeleted
            FROM Utilizador AS u INNER JOIN TipoUtilizador AS tu ON u.idTipo = tu.id 
            WHERE u.id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindParam("id", $_GET["id"]);
        $stmt -> execute();

        if ($stmt -> rowCount() == 1) {
            $user = $stmt -> fetch();
        } else {
            gotoListUsers();
        }

        $query = "
            SELECT *
            FROM TipoUtilizador
            ORDER BY nome;
        ";        
        $stmt = $dbo -> prepare($query);
        $stmt -> execute();
        $userTypes = $stmt -> fetchAll();

        if ($user["tipoId"] == USER_TYPE_INSPECTOR) {
            $query = "
                SELECT li.id, li.nome, cv.nome AS categoria
                FROM LinhaInspecao AS li INNER JOIN CategoriaVeiculo AS cv ON li.idCategoria = cv.id;
            ";        
            $stmt = $dbo -> prepare($query);
            $stmt -> execute();
            $linhas = $stmt -> fetchAll();

            $query = "
                SELECT *
                FROM LinhaInspecao_Utilizador
                WHERE idUtilizador = :id;
            ";        
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("id", $user["id"]);
            $stmt -> execute();
            $userLinha = $stmt -> fetch();
            if ($stmt -> rowCount() == 0) {
                $userLinha["idLinha"] = -100;
            }
        }
    } else {
        gotoIndex();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/edit_user.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/login_register.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <script src="/ProjetoPWBD/assets/js/edit_user.js"></script>
    <link rel="icon" href="/ProjetoPWBD/assets/img/icon.png">
    
    <script>
        window.onload = function() {
            activateLiveCheckEditUser();
            <?php
                if (isset($_SESSION["badEdit"])) {
                    echo "badEdit(".$_SESSION["badEdit"]["code"].", '".$_SESSION["badEdit"]["reason"]."');";
                    unset($_SESSION["badEdit"]);    
                }

                echo "showInfoEditUser(".json_encode($user).");"
            ?>
        }
    </script>
    <title>CI | Editar utilizador</title>
</head>
<body>
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/navbar.php");
    ?>
    <div class="eu-zone">
        <div class="eu-warning" id="badWarning">
            
        </div>
        <div class="eu-panel">
            <h1>
                Editar utilizador
            </h1>
            <div class="eu-form">
                <form action="/ProjetoPWBD/scripts/php/edita_utilizador.php" method="POST">
                    <div class="eu-form-category">
                        Informação da conta
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_username">
                            ID
                        </label>
                        <div class="eu-inputGroup-input">
                            <input type="text" name="eu_id" id="eu_id" readonly required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_username">
                            Nome de Utilizador<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="text" name="eu_username" id="eu_username" required>
                            <span>Tamanho: 4-16 caracteres</span>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_email">
                            Email<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="email" name="eu_email" id="eu_email" required>
                            <span>Tamanho: 6-128 caracteres</span>
                        </div>
                    </div>

                    <div class="eu-inputGroup">
                        <label for="eu_pwd">
                            Nova palavra-passe
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="password" name="eu_pwd" id="eu_pwd">
                            <span>Regras: 4-64 caracteres, 1 caracter maiúsculo, 1 caracter minúsculo, 1 número.</span>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_pwd2">
                            Confirmar palavra-passe
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="password" name="eu_pwd2" id="eu_pwd2">
                        </div>
                    </div>

                    <div class="eu-inputGroup">
                        <label for="eu_userType">
                            Tipo utilizador<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <select id="eu_userType" name="eu_userType">
                                <?php
                                    foreach ($userTypes as $type) {
                                        // Se o tipo for apagado não coloca na lista
                                        if ($type["id"] == USER_TYPE_DELETED && $user["tipoId"] != USER_TYPE_DELETED) {
                                            continue;
                                        }
                                        if ($type["id"] == $user["tipoId"]) {
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

                    <?php
                        if (isset($linhas)) {
                            echo "
                                <div class='eu-inputGroup'>
                                    <label for='eu_userTye'>
                                        Linha de inspecao<sup>*</sup>
                                    </label>
                                    <div class='eu-inputGroup-input'>
                                        <select id='eu_linha' name='eu_linha'>
                            ";
                            if ($userLinha["idLinha"] == -100) {
                                echo "
                                    <option value='-100' disabled selected>
                                        Nenhuma atribuída
                                    </option>
                                ";
                            }
                            foreach($linhas as $linha) {
                                if ($userLinha["idLinha"] == $linha["id"]) {
                                    echo "
                                        <option value=".$linha["id"]." selected>
                                            ".$linha["categoria"]." - ".$linha["nome"]."
                                        </option>
                                    ";
                                } else {
                                    echo "
                                        <option value=".$linha["id"].">
                                            ".$linha["categoria"]." - ".$linha["nome"]."
                                        </option>
                                    ";
                                }
                            }
                            echo "
                                            
                                        </select>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                    


                    <div class="eu-form-category">
                        Dados pessoais:
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_name">
                            Primeiro e último nome<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="text" name="eu_name" id="eu_name" required>
                            <span>Tamanho: 6-64 caracteres. Sem pontuação.</span>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_mobile">
                            Nº telemóvel<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="number" name="eu_mobile" id="eu_mobile" required>
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_tel">
                            Nº telefone
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="number" name="eu_tel" id="eu_tel">
                            <span>Tamanho: 9 digitos.</span>
                        </div>
                    </div>

                    <div class="eu-inputBtn">
                        <a href="/ProjetoPWBD/admin/users.php">
                            Cancelar
                        </a>

                        <input type="submit" value="Editar" name="editBtn" id="editBtn">
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