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
        $novehicles = true;
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
            /*$query = "
                SELECT *
                FROM LinhaInspecao
                WHERE idCategoria = :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("id", $vehicle["idCategory"]);
            $stmt -> execute();
            $lines = $stmt -> fetchAll();
            $lines_final = array();
            
            print_r($lines);
            exit();*/
            
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
                    array_push($datesAvailable, array("date" => $date, "linha" => "1" /*$linha*/));
                }
                
            }
            /*foreach($datesAvailable as $yes) {
                print_r($yes["data"] -> format("Y-m-d H:i:s") . " | linha: " . $yes["linha"]);
                echo "<br>";
            }*/
        }
        if ($vehicle["idCategory"] == 1) {
            $validHours = "
                <table>
                    <tr>
                        <th>
                            Manha
                        </th>
                        <th>
                            Tarde
                        </th>
                    </tr>
                    <tr>
                        <td>
                            09:00
                        <td>
                        <td>
                            14:00
                        <td>
                    </tr>
                    <tr>
                        <td>
                            10:00
                        <td>
                        <td>
                            15:00
                        <td>
                    </tr>
                    <tr>
                        <td>
                            11:00
                        <td>
                        <td>
                            16:00
                        <td>
                    </tr>
                    <tr>
                        <td>
                            12:00
                        <td>
                        <td>
                            17:00
                        <td>
                    </tr>
                </table>
            ";
            //$validHours = ["09:00", "10:00", "11:00", "12:00", "14:00", "15:00", "16:00", "17:00"];
            $duration = "1 hora";
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
                                            Segunda a Sexta-feira
                                        </th>
                                        <th>
                                            Sábado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            9:00 - 13:00
                                        </td>
                                        <td>
                                            9:00 - 13:00
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            14:00 - 18:00
                                        </td>
                                        <td>
                                            Inválido
                                        </td>
                                    </tr>
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
                    <div>
                            <br>
                            <br>
                            Horas: '.$validHours.'
                        </div>
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