<?php
    // WIP / NOT TESTED
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();
    if (!isset($_GET["id"])) {
        header("Location: ./vehicles.php");
        die();
    }
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    
    $query = "
        SELECT v.id, v.matricula, vu.idUtilizador AS idUser, cv.id AS idCategory
        FROM veiculo AS v
            INNER JOIN Veiculo_Utilizador AS vu ON v.id = vu.idVeiculo
            INNER JOIN CategoriaVeiculo AS cv ON v.idCategoria = cv.id
        WHERE v.id = :id
    ";
    $stmt = $dbo->prepare($query);
    $stmt->bindValue("id", $_GET["id"]);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        header("Location: ./vehicles.php");
    } else {
        $novehicles = false;
        $vehicle = $stmt->fetch();
    }
    
    if (isset($vehicle)) {
        $query = "
            SELECT i.horaInicio AS dateStart, i.horaFim AS dateEnd, i.idLinha AS linha
            FROM Inspecao AS i
                INNER JOIN LinhaInspecao AS li ON i.idLinha = li.id
                INNER JOIN CategoriaVeiculo AS cv ON li.idCategoria = cv.id
            WHERE cv.id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $vehicle["idCategory"]);
        $stmt -> execute();
        $invalidDates = $stmt -> fetchAll();
        
        if ($vehicle["idCategory"] == 1) {
            $query = "
                SELECT *
                FROM LinhaInspecao
                WHERE idCategoria = :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("id", $vehicle["idCategory"]);
            $stmt -> execute();
            $lines = $stmt -> fetchAll();
            
            $start = new DateTime(date("Y-m-d H:i:s", strtotime("09:00:00")));
            $end = new DateTime(date("Y-m-d H:i:s", strtotime("17:00:00")));
            $dateStart = date_add($start, new DateInterval("P2D"));
            $dateEnd = date_add($end, new DateInterval("P30D"));

            $interval = new DatePeriod($dateStart, new DateInterval('PT1H'), $dateEnd);
            $datesAvailable = array();
            foreach($interval as $date) {
                $weekDay = $date -> format("w");
                $hour = $date -> format("H");
                if ($weekDay == 0) {
                    continue;
                } elseif ($weekDay == 6 && $hour > 13) {
                    continue;
                } else {
                    if ($hour < 9 || $hour > 18 ) {
                        continue;
                    }
                }
                $isValid = true;
                $linha = 1;
                foreach($invalidDates as $invDate) {
                    if ( $date == new DateTime($invDate["dateStart"]) ) {
                        $isValid = false;
                        break;
                    }
                }
                
                if ($isValid) {
                    array_push($datesAvailable, array("date" => $date, "linha" => $linha));
                }
                
            }
            /*foreach($datesAvailable as $yes) {
                print_r($yes["data"] -> format("Y-m-d H:i:s") . " | linha: " . $yes["linha"]);
                echo "<br>";
            }*/
        }
        $hourEnd = new DateTime(date("Y-m-d H:i:s", strtotime("18:00:00")));
        $hourEndDate = date_add($hourEnd, new DateInterval("P2D"));
        if ($vehicle["idCategory"] == 1) {
            $intervalString = "PT30M";
            $duration = "30 minutos";
        } else {
            $intervalString = "PT1H";
            $duration = "1 hora";
        }
        $hourinterval = new DatePeriod($dateStart, new DateInterval($intervalString), $hourEndDate);
        $validHours = array();
        $i = 0;
        foreach ($hourinterval as $h) {
            $hour = $h -> format("H");
            if (($hour < 9 || $hour > 18 ) || $hour == 13) {
                continue;
            } elseif ($hour < 13) {
                array_push($validHours, array($h->format("H:i")));
            } elseif ($hour > 13) {
                array_push($validHours[$i], $h->format("H:i"));
                $i++;
            }
        }
            // $validHours = "";
            // $validHours = ["09:00", "10:00", "11:00", "12:00", "14:00", "15:00", "16:00", "17:00"];
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
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/new_inspection.css">
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
                    $lastId = array_key_last($datesAvailable);
                    echo '
                        <div class="ni-schedule">
                            <div class="ni-schedule-title">
                                Horário válido para marcações
                            </div>
                            <table class="ni-schedule-table">
                                <thead>
                                    <tr>
                                        <th>
                                            Manhã
                                        </th>
                                        <th>
                                            Tarde<br>(exceto Sábado)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                    ';
                    foreach($validHours as $h) {
                        echo '
                                    <tr>
                                        <td>
                                            '. $h[0] .'
                                        </td>
                                        <td>
                                            '. $h[1] .'
                                        </td>
                                    </tr>
                        ';
                    }
                    echo '
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            Escolha uma data entre '.$datesAvailable[0]["date"] -> format("d-m-Y").' e '.$datesAvailable[$lastId]["date"] -> format("d-m-Y").'<br>
                                            Duração: '.$duration.'
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="eu-form">
                            <form action="/ProjetoPWBD/scripts/php/new_inspection.php" method="POST">
                                <div class="eu-form-category">
                                    Detalhes da Marcação
                                </div>
                                <input class="type-input" type="hidden" name="ni_vehicle" id="ni_vehicle" value="'.$_GET["id"].'"" readonly required>
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