<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();
    if (!isset($_GET["id"])) {
        sendErrorMessage(true, "Veiculo inválido", "/ProjetoPWBD/admin/vehicles.php");
    }

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    $query = "SELECT * FROM categoriaveiculo;";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $result = $stmt -> fetchAll();
    define("CATEGORIES", $result);
    $idtoedit = $_GET["id"];
    $query = "SELECT idVeiculo, idUtilizador FROM veiculo_utilizador WHERE idVeiculo = :id;";
    $stmt = $dbo->prepare($query);
    $stmt->bindValue("id", $idtoedit);
    $stmt->execute();
    if ($stmt->rowCount() != 1) {
        sendErrorMessage(true, "Veiculo inválido (não existe)", "/ProjetoPWBD/admin/vehicles.php");
    }
    $old_user = $stmt->fetch()["idUtilizador"];
    $query = "SELECT id, nome FROM utilizador";
    $stmt = $dbo->prepare($query);
    $stmt->execute();
    define("USERS", $stmt->fetchAll());
    $query = "SELECT veiculo.id, veiculo.matricula, veiculo.ano, veiculo.marca, categoriaveiculo.id categoria
        FROM veiculo INNER JOIN categoriaveiculo ON veiculo.idCategoria = categoriaveiculo.id
        WHERE veiculo.id = :id;";
    $stmt = $dbo->prepare($query);
    $stmt->bindValue("id", $idtoedit);
    $stmt->execute();
    if ($stmt->rowCount() != 1) {
        sendErrorMessage(true, "Erro a obter detalhes do veículo", "/ProjetoPWBD/admin/vehicles.php");
    }
    $result = $stmt->fetch();
    define("VEHICLE", $result);
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
    
    <style>
        .eu-inputBtn {
            justify-content: center;
        }
    </style>

    <script>
        window.onload = function() {
            <?php
                if (isset($_SESSION["badEdit"])) {
                    echo "showBadEdit(".json_encode($_SESSION["badEdit"]).");";
                    unset($_SESSION["badEdit"]);    
                }

                
            ?>
        }
    </script>
    <title>CI | Editar Veículo</title>
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
                Editar Veículo
            </h1>
            <div class="eu-form">
                <form action="/ProjetoPWBD/scripts/php/edit_vehicle_admin.php" method="POST">
                    <div class="eu-form-category">
                        Detalhes do Veículo
                    </div>
                    <input class="type-input" type="hidden" name="nv_id" id="nv_id" value="<?php echo $_GET["id"]; ?>" readonly required>
                    
                    <div class="eu-inputGroup">
                        <label for="nv_matricula">
                            Matrícula<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="text" name="nv_matricula" id="nv_matricula" value="<?php echo VEHICLE["matricula"]; ?>" required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="nv_year">
                            Ano<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="number" min="1900" name="nv_year" id="nv_year" value="<?php echo VEHICLE["ano"]; ?>" required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="nv_brand">
                            Marca<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="text" name="nv_brand" id="nv_brand" value="<?php echo VEHICLE["marca"]; ?>" required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="nv_cat">
                            Categoria<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <select id="nv_cat" name="nv_cat">
                                <?php
                                    foreach (CATEGORIES as $cat) {
                                        if ($cat["id"] === VEHICLE["categoria"]) {
                                            echo "
                                                <option value='". $cat["id"] ."' selected>".$cat["nome"]."</option>
                                            ";
                                        } else {
                                            echo "
                                                <option value='". $cat["id"] ."'>".$cat["nome"]."</option>
                                            ";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="nv_user">
                            Utilizador<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <select name="nv_user" id="nv_user">
                                    <?php
                                        foreach (USERS as $user) {
                                            if ($user["id"] == $old_user) {
                                                echo "
                                                    <option value='". $user["id"] ."' selected>[".$user["id"]."] ".$user["nome"]."</option>
                                                ";
                                            } else {
                                                echo "
                                                    <option value='". $user["id"] ."'>[".$user["id"]."] ".$user["nome"]."</option>
                                                ";
                                            }
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="eu-inputBtn">
                        <input type="submit" value="Editar veículo" name="submit" id="editBtn">
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