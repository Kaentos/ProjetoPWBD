<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_POST["nv_matricula"]) && isset($_POST["nv_year"]) && isset($_POST["nv_brand"]) && isset($_POST["nv_cat"])) {
        $matricula = strtoupper(str_replace("-", "", $_POST["nv_matricula"]));
        if (preg_match(REGEX_PLATE, $matricula) !== 1) {
            sendBadEdit("Matrícula Inválida", ["nv_matricula"], "/ProjetoPWBD/vehicle/new.php");
        }
        $year = intval($_POST["nv_year"]);
        if ($year < 1900 || $year > getdate()["year"]) {
            sendBadEdit("Ano inválido", ["nv_year"], "/ProjetoPWBD/vehicle/new.php");
        }
        $vehicle = array(
            "matricula" => $matricula,
            "year" => $_POST["nv_year"],
            "brand" => $_POST["nv_brand"],
            "cat" => $_POST["nv_cat"]
        );
        include("basedados.h");
        $query = "SELECT matricula FROM veiculo
            WHERE matricula = :matricula;";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("matricula", $matricula);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            sendBadEdit("Matrícula introduzida já está registada", ["nv_matricula"], "/ProjetoPWBD/vehicle/new.php");
        }
        $query = "INSERT INTO veiculo (matricula, ano, marca, idCategoria) VALUES (:matricula, :ano, :marca, :idCategoria);";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("matricula", $vehicle["matricula"]);
        $stmt->bindValue("ano", $vehicle["year"]);
        $stmt->bindValue("marca", $vehicle["brand"]);
        $stmt->bindValue("idCategoria", $vehicle["cat"]);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $query = "SELECT id FROM veiculo WHERE matricula = :matricula;";
            $stmt = $dbo->prepare($query);
            $stmt->bindValue("matricula", $vehicle["matricula"]);
            $stmt->execute();
            $inserted_id = $stmt->fetch()["id"];
            $query = "INSERT INTO veiculo_utilizador VALUES (:id, :userid);";
            $stmt = $dbo->prepare($query);
            $stmt->bindValue("id", $inserted_id);
            $stmt->bindValue("userid", LOGIN_DATA["id"]);
            $stmt->execute();
        }
        sendErrorMessage(false, "Veículo registado", "/ProjetoPWBD/vehicle/");
    } else {
        sendErrorMessage(true, "Valores de entrada inválidos", "/ProjetoPWBD/vehicle/");
    }
?>