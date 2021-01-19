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
            sendErrorMessage(true, "Veiculo inválido (não existe ou não pertence ao utilizador)", "/ProjetoPWBD/vehicle/");
        }
        $query = "DELETE FROM veiculo WHERE id = :id";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        sendErrorMessage(false, "Veiculo eliminado com sucesso", "/ProjetoPWBD/vehicle/");
    } else {
        sendErrorMessage(true, "Veiculo inválido", "/ProjetoPWBD/vehicle/");
    }
?>