<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_POST["ni_startdate"]) && isset($_POST["ni_starttime"]) && isset($_POST["ni_vehicle"])) {
        
        $inspection = array(
            "startdt" => date_create_from_format("Y-m-d-H:i", $_POST["ni_startdate"]."-".$_POST["ni_starttime"]),
            "vehicle" => $_POST["ni_vehicle"]
        );

        include("basedados.h");
        $query = "SELECT idVeiculo FROM veiculo_utilizador WHERE idUtilizador = :userid AND idVeiculo = :id;";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("userid", LOGIN_DATA["id"]);
        $stmt->bindValue("id", $inspection["vehicle"]);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            sendErrorMessage(true, "Veiculo inválido (não existe ou não pertence ao utilizador)", "/ProjetoPWBD/vehicle");
        }
        $query = "
            SELECT v.id, v.matricula, vu.idUtilizador AS idUser, cv.id AS idCategory
            FROM veiculo AS v
                INNER JOIN Veiculo_Utilizador AS vu ON v.id = vu.idVeiculo
                INNER JOIN CategoriaVeiculo AS cv ON v.idCategoria = cv.id
            WHERE v.id = :id AND vu.idUtilizador = :userid
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $_POST["ni_vehicle"]);
        $stmt->bindValue("userid", LOGIN_DATA["id"]);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            sendErrorMessage(true, "Não há veículo registado com o ID pedido", "/ProjetoPWBD/vehicle");
        } else {
            $vehicle = $stmt->fetch();
        }
        $query = "
            SELECT i.idVeiculo, i.horaInicio AS dateStart, i.horaFim AS dateEnd, i.idLinha AS linha
            FROM Inspecao AS i
                INNER JOIN LinhaInspecao AS li ON i.idLinha = li.id
                INNER JOIN CategoriaVeiculo AS cv ON li.idCategoria = cv.id
            WHERE cv.id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $vehicle["idCategory"]);
        $stmt -> execute();
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

        $query = "
            SELECT horaInicio 
            FROM inspecao
            WHERE idVeiculo = :id
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $inspection["vehicle"]);
        $stmt->execute();
        $prevInspections = $stmt->fetchAll();
        foreach($prevInspections as $prev) {
            $dateDiff = date_diff(date_create_from_format("Y-m-d H:i:s", $prev["horaInicio"]), $inspection["startdt"]);
            if (!($dateDiff->d >= 2)) {
                sendErrorMessage(true, "Só pode marcar inspeções consecutivas para cada veículo num espaço mínimo de 2 dias", "/ProjetoPWBD/vehicle");
            }
        }

        if ($vehicle["idCategory"] == 1 || $vehicle["idCategory"] == 2) {
            $intervalString = "PT30M";
        } else {
            $intervalString = "PT1H";
        }
        $start = new DateTime(date("Y-m-d H:i:s", strtotime("09:00:00")));
        $end = new DateTime(date("Y-m-d H:i:s", strtotime("18:00:00")));
        $dateStart = date_add($start, new DateInterval("P3D"));
        $dateEnd = date_add($end, new DateInterval("P30D"));
        $interval = new DatePeriod($dateStart, new DateInterval($intervalString), $dateEnd);
        $datesAvailable = array();
        foreach ($lines as $line) {
            $linha = $line["id"];
            foreach($interval as $date) {
                $weekDay = $date -> format("w");
                $hour = $date -> format("H");
                if ($weekDay == 0 || $hour == 13) {
                    continue;
                } elseif ($weekDay == 6 && $hour > 13) {
                    continue;
                } else {
                    if ($hour < 9 || $hour >= 18 ) {
                        continue;
                    }
                }
                $isValid = true;
                foreach($invalidDates as $invDate) {
                    if ( $date == new DateTime($invDate["dateStart"]) && $linha == $invDate["linha"]) {
                        $isValid = false;
                        break;
                    }
                }
                
                if ($isValid) {
                    array_push($datesAvailable, array("date" => $date, "linha" => $linha));
                }
                
            }
        }

        
        $valido = false;
        foreach ($datesAvailable as $d) {
            if ($inspection["startdt"] == $d["date"]) {
                $valido = true;
                $validline = $d["linha"];
                break;
            }
        }
        if (!$valido) {
            sendBadEdit("Data Inválida", ["ni_startdate", "ni_starttime"], "/ProjetoPWBD/customer/new.php?id=".$_POST["ni_vehicle"]);
        }
        $query = "
            INSERT INTO inspecao (horaInicio, horaFim, idVeiculo, idLinha) VALUES (:horaInicio, :horaFim, :idVeiculo, :idLinha);
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("horaInicio", $inspection["startdt"]->format("Y-m-d H:i:00"));
        $stmt->bindValue("horaFim", date_add($inspection["startdt"], new DateInterval($intervalString))->format("Y-m-d H:i:00"));
        $stmt->bindValue("idVeiculo", $inspection["vehicle"]);
        $stmt->bindValue("idLinha", $validline);
        $stmt->execute();

        sendErrorMessage(false, "Inspeção adicionada com sucesso", "/ProjetoPWBD/customer/");
    }
    sendErrorMessage(true, "Valores de entrada inválidos", "/ProjetoPWBD/vehicle");
?>