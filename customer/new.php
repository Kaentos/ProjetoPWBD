<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }

    include("../scripts/php/basedados.h");
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
    
    <script>
        window.onload = function() {
            <?php
                if (isset($_SESSION["badEdit"])) {
                    echo "badEdit(".$_SESSION["badEdit"]["code"].", '".$_SESSION["badEdit"]["reason"]."');";
                    unset($_SESSION["badEdit"]);    
                }

                
            ?>
            let today = new Date();
            // document.getElementById("ni_startdate").min = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`;
            document.getElementById("ni_startdate").min = today.toISOString();
        }
    </script>
    <title>CI | Nova Marcação</title>
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
                Nova marcação
            </h1>
            <div class="eu-form">
                <form action="/ProjetoPWBD/customer/" method="POST">
                    <div class="eu-form-category">
                        Detalhes da Marcação
                    </div>
                    <div class="eu-inputGroup">
                        <label for="ni_startdate">
                            Data<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="date" name="ni_startdate" id="ni_startdate" required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="ni_starttime">
                            Hora de Início<sup>*</sup>
                        </label>
                        <div class="eu-inputGroup-input">
                            <input class="type-input" type="time" name="ni_starttime" id="ni_starttime" required>
                        </div>
                    </div>
                    <div class="eu-inputGroup">
                        <label for="eu_pwd">
                            Categoria de veículo
                        </label>
                        <div class="eu-inputGroup-input">
                            <select id="ni_cat" name="ni_cat">
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