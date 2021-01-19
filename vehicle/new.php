<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    $query = "SELECT * FROM categoriaveiculo;";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $result = $stmt -> fetchAll();
    define("CATEGORIES", $result);
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
    <script src="/ProjetoPWBD/assets/js/messages.js"></script>
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
                    echo "badEdit(".$_SESSION["badEdit"]["code"].", '".$_SESSION["badEdit"]["reason"]."');";
                    unset($_SESSION["badEdit"]);    
                }

                
            ?>
        }
    </script>
    <title>CI | Registar Veículo</title>
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
                Registar Veículo
            </h1>
            <div class="eu-form">
                <form action="/ProjetoPWBD/scripts/php/new_vehicle.php" method="POST">
                    <div class="eu-form-category">
                        Detalhes do Veículo
                    </div>
                    <div class="eu-inputGroup">
                        <label for="nv_matricula">
                            Matrícula<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="text" name="nv_matricula" id="nv_matricula" required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="nv_year">
                            Ano<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="number" min="1900" name="nv_year" id="nv_year" required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="nv_brand">
                            Marca<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="text" name="nv_brand" id="nv_brand" required>
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
                                        echo "
                                            <option value='". $cat["id"] ."'>".$cat["nome"]."</option>
                                        ";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="eu-inputBtn">
                        <input type="submit" value="Registar veículo" name="submit" id="editBtn">
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