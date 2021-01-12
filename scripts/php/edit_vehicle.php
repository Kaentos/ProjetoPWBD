<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_POST["nv_id"]) && isset($_POST["nv_matricula"]) && isset($_POST["nv_year"]) && isset($_POST["nv_brand"]) && isset($_POST["nv_cat"])) {
        $matricula = strtoupper(str_replace("-", "", $_POST["nv_matricula"]));
        if (preg_match(REGEX_PLATE, $matricula) !== 1) {
            die("Matricula Invalida");
        }
        $year = intval($_POST["nv_year"]);
        if ($year < 1900 || $year > getdate()["year"]) {
            die("Ano Invalido");
        }
        $vehicle = array(
            "id" => $_POST["nv_id"],
            "matricula" => $matricula,
            "year" => $_POST["nv_year"],
            "brand" => $_POST["nv_brand"],
            "cat" => $_POST["nv_cat"]
        );
        include("basedados.h");
        $query = "SELECT idVeiculo FROM veiculo_utilizador WHERE idUtilizador = :userid AND idVeiculo = :id;";
        $stmt = $dbo -> prepare($query);
        $stmt->bindValue("userid", LOGIN_DATA["id"]);
        $stmt->bindValue("id", $vehicle["id"]);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            die("Veiculo invalido (não existe ou não pertence ao utilizador)");
        }
        $query = "SELECT matricula FROM veiculo WHERE id = :id";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $vehicle["id"]);
        $stmt->execute();
        $old_matricula = $stmt->fetch()["matricula"];
        if (strcmp($old_matricula, $matricula) != 0) {
            $query = "SELECT matricula FROM veiculo
                WHERE matricula = :matricula;";
            $stmt = $dbo->prepare($query);
            $stmt->bindValue("matricula", $matricula);
            $stmt->execute();
            if ($stmt->rowCount() != 0) {
                die("Matricula ja esta registada");
            }
        }
        $query = "UPDATE veiculo SET matricula = :matricula, ano = :ano, marca = :marca, idCategoria = :categoria WHERE veiculo.id = :id;";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $vehicle["id"]);
        $stmt->bindValue("matricula", $vehicle["matricula"]);
        $stmt->bindValue("ano", $vehicle["year"]);
        $stmt->bindValue("marca", $vehicle["brand"]);
        $stmt->bindValue("categoria", $vehicle["cat"]);
        $stmt->execute();
        header("Location: /ProjetoPWBD/vehicle/index.php");
        die();
    } else {
        header("Location: /ProjetoPWBD/vehicle/");
        die();
    }
?>