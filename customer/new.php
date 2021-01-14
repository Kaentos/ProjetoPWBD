<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (!isset($_GET["id"])) {
        header("Location: ../vehicle");
        die();
    }
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    // TODO https://www.php.net/manual/en/class.dateperiod.php
    // Creating all dates out of strings might be too expensive
    // Using a 30-day period starting from current_time + 3d and excluding invalid dates might be a better idea
    // Don't even bother generating dates for Sundays
    // Watch out for methods that aren't in PHP 7.0+ by default
    // Also I should probably fix some page headers not being centered

    $query = "SELECT veiculo.id, veiculo.matricula FROM veiculo
        INNER JOIN veiculo_utilizador ON veiculo.id=veiculo_utilizador.idVeiculo
        WHERE veiculo_utilizador.idUtilizador = :userid";
    $stmt = $dbo->prepare($query);
    $stmt->bindValue("userid", LOGIN_DATA["id"]);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $novehicles = true;
    } else {
        $novehicles = false;
        $result = $stmt->fetchAll();
        define("VEHICLES", $result);
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
            <?php
                echo $novehicles ? "<h1>Registe um veículo antes de criar marcação</h1>" : "<h1>Nova marcação</h1>";
                if (!$novehicles) {
                    echo '
                        <div class="eu-form">
                            <form action="/ProjetoPWBD/scripts/php/new_inspection.php" method="POST">
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
                                    <label for="ni_vehicle">
                                        Veículo
                                    </label>
                                    <div class="eu-inputGroup-input">
                                        <select id="ni_vehicle" name="ni_vehicle">
                    ';
                    foreach (VEHICLES as $v) {
                        echo "
                            <option value='". $v["id"] ."'>".$v["matricula"]."</option>
                        ";
                    }
                    echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="eu-inputBtn">
                                    <input type="submit" value="Criar marcação" name="submit" id="editBtn">
                                </div>
                            </form>
                        </div>
                    ';
                } else {
                    echo "
                        <div class='eu-inputBtn'>    
                            <a href='/ProjetoPWBD/vehicle/new.php'>Registar veículo</a>
                        </div>
                    ";
                }
                ?>
        </div>
    </div>
    
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>