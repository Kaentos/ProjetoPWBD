<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        include("basedados.h");
        $query = "SELECT idVeiculo FROM veiculo_utilizador WHERE idUtilizador = :userid AND idVeiculo = :id;";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("userid", LOGIN_DATA["id"]);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            die("Veiculo invalido (não existe ou não pertence ao utilizador)");
        }
        $query = "DELETE FROM veiculo WHERE id = :id";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        header("Location: /ProjetoPWBD/vehicle/index.php");
        die();
    } else {
        header("Location: /ProjetoPWBD/vehicle/");
        die();
    }
?>