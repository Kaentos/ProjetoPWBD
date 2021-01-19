<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (!isset($_GET["id"])) {
        sendErrorMessage(true, "Veiculo inválido", "../vehicle");
    }
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    
    $query = "
        SELECT i.horaInicio, i.idVeiculo
        FROM inspecao AS i
            INNER JOIN veiculo AS v ON i.idVeiculo=v.id
            INNER JOIN Veiculo_Utilizador AS vu ON v.id = vu.idVeiculo
        WHERE i.id = :id AND vu.idUtilizador = :userid
    ";
    $stmt = $dbo->prepare($query);
    $stmt->bindValue("id", $_GET["id"]);
    $stmt->bindValue("userid", LOGIN_DATA["id"]);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        sendErrorMessage(true, "Inspeção Inválida", "index.php");
    }
    $vehicleid = $stmt->fetch()["idVeiculo"];

    $query = "
        SELECT v.id, v.matricula, vu.idUtilizador AS idUser, cv.id AS idCategory
        FROM veiculo AS v
            INNER JOIN Veiculo_Utilizador AS vu ON v.id = vu.idVeiculo
            INNER JOIN CategoriaVeiculo AS cv ON v.idCategoria = cv.id
        WHERE v.id = :id
    ";
    $stmt = $dbo->prepare($query);
    $stmt->bindValue("id", $vehicleid);
    $stmt->execute();
    $vehicle = $stmt->fetch();
    
    if (isset($vehicle)) {
        $query = "
            SELECT i.horaInicio AS dateStart, i.horaFim AS dateEnd, i.idLinha AS linha
            FROM Inspecao AS i
                INNER JOIN LinhaInspecao AS li ON i.idLinha = li.id
                INNER JOIN CategoriaVeiculo AS cv ON li.idCategoria = cv.id
            WHERE cv.id = :id;
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $vehicle["idCategory"]);
        $stmt->execute();
        $invalidDates = $stmt -> fetchAll();
        $query = "
            SELECT *
            FROM LinhaInspecao
            WHERE idCategoria = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $vehicle["idCategory"]);
        $stmt -> execute();
        $lines = $stmt -> fetchAll();
        if ($vehicle["idCategory"] == 1 || $vehicle["idCategory"] == 2) {
            $intervalString = "PT30M";
            $duration = "30 minutos";
            $step = "1800";
        } else {
            $intervalString = "PT1H";
            $duration = "1 hora";
            $step = "3600";
        }

        $start = new DateTime(date("Y-m-d H:i:s", strtotime("09:00:00")));
        $end = new DateTime(date("Y-m-d H:i:s", strtotime("18:00:00")));
        $dateStart = date_add($start, new DateInterval("P3D"));
        $dateEnd = date_add($end, new DateInterval("P30D"));

        $interval = new DatePeriod($dateStart, new DateInterval($intervalString), $dateEnd);
        $datesAvailable = array();
        foreach($interval as $date) {
            $weekDay = $date -> format("w");
            $hour = $date -> format("H");
            if ($weekDay == 0 || $hour == 13) {
                continue;
            } elseif ($weekDay == 6 && $hour >= 13) {
                continue;
            } else {
                if ($hour < 9 || $hour >= 18 ) {
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
        $hourEnd = new DateTime(date("Y-m-d H:i:s", strtotime("18:00:00")));
        $hourEndDate = date_add($hourEnd, new DateInterval("P3D"));
        $hourinterval = new DatePeriod($dateStart, new DateInterval($intervalString), $hourEndDate);
        $validHours = array();
        $i = 0;
        foreach ($hourinterval as $h) {
            $hour = $h -> format("H");
            if (($hour < 9 || $hour >= 18 ) || $hour == 13) {
                continue;
            } elseif ($hour < 13) {
                array_push($validHours, array($h->format("H:i")));
            } elseif ($hour > 13) {
                array_push($validHours[$i], $h->format("H:i"));
                $i++;
            }
        }
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
                    echo "showBadEdit(".json_encode($_SESSION["badEdit"]).");";
                    unset($_SESSION["badEdit"]);
                }
            ?>
        }
    </script>
    <title>CI | Editar Marcação</title>
</head>
<body>
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/navbar.php");
    ?>
    <div class="eu-zone">
        <div class="eu-warning" id="badWarning">
            
        </div>
        <div class="eu-panel">
            <h1>Editar marcação</h1>
            <?php
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
                        <form action="/ProjetoPWBD/scripts/php/edit_inspection.php" method="POST">
                            <div class="eu-form-category">
                                Detalhes da Marcação
                            </div>
                            <input class="type-input" type="hidden" name="ni_inspection" id="ni_inspection" value="'.$_GET["id"].'"" readonly required>
                            <div class="eu-inputGroup">
                                <label for="ni_startdate">
                                    Data<sup>*</sup>
                                </label>
                                <div class="eu-inputGroup-input">
                                    <input class="type-input" type="date" min="'.$datesAvailable[0]["date"] -> format("Y-m-d").'" max="'.$datesAvailable[$lastId]["date"] -> format("Y-m-d").'" name="ni_startdate" id="ni_startdate" required>
                                </div>
                            </div>
                            <div class="eu-inputGroup">
                                <label for="ni_starttime">
                                    Hora de Início<sup>*</sup>
                                </label>
                                <div class="eu-inputGroup-input">
                                    <input class="type-input" type="time" step="'.$step.'" min="'.$validHours[0][0].'" max="'.$validHours[count($validHours)-1][count($validHours[count($validHours)-1])-1].'" name="ni_starttime" id="ni_starttime" required>
                                </div>
                            </div>
                            <div class="eu-inputBtn">
                                <input type="submit" value="Editar marcação" name="submit" id="editBtn">
                            </div>
                        </form>
                    </div>
                ';
                ?>
        </div>
    </div>
    
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>