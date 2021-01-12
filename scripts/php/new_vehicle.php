<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_POST["nv_matricula"]) && isset($_POST["nv_year"]) && isset($_POST["nv_brand"]) && isset($_POST["nv_cat"])) {
        $matricula = strtoupper(str_replace("-", "", $_POST["nv_matricula"]));
        if (preg_match(REGEX_PLATE, $matricula) !== 1) {
            die("Matricula Invalida");
        }
        $year = intval($_POST["nv_year"]);
        if ($year < 1900 && $year < getdate()["year"]) {
            die("Ano Invalido");
        }
        $vehicle = array(
            "matricula" => $matricula,
            "year" => $_POST["nv_year"],
            "brand" => $_POST["nv_brand"],
            "cat" => $_POST["nv_cat"]
        );
        include("basedados.h");
        $query = "SELECT matricula FROM veiculo
            WHERE matricula = $matricula;";
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() !== 0) {
            die("Matricula ja esta registada");
        }
        $query = "INSERT INTO veiculo (matricula, ano, marca, idCategoria) VALUES (:matricula, :ano, :marca, :idCategoria);";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("matricula", $vehicle["matricula"]);
        $stmt->bindValue("ano", $vehicle["year"]);
        $stmt->bindValue("marca", $vehicle["brand"]);
        $stmt->bindValue("idCategoria", $vehicle["cat"]);
        $stmt->execute();
        if ($stmt->rowCount() === 1) {
            $query = "SELECT id FROM veiculo WHERE matricula = :matricula;";
            $stmt = $dbo->prepare($query);
            $stmt->bindValue("matricula", $vehicle["matricula"]);
            $stmt->execute();
            $inserted_id = $stmt->fetch()["id"];
            $query = "INSERT INTO veiculo_utilizador VALUES (".$inserted_id.", ".LOGIN_DATA["id"].");";
            $stmt = $dbo->prepare($query);
            $stmt->execute();
        }
        header("Location: /ProjetoPWBD/vehicle/index.php");
        die();
    } else {
        header("Location: /ProjetoPWBD/vehicle/");
        die();
    }
?>