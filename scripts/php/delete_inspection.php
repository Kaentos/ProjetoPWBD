<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_GET["id"])) {
        
        $inspection = $_GET["id"];
        include("basedados.h");
        $query = "
            SELECT i.id, i.horaInicio
            FROM inspecao AS i
                INNER JOIN veiculo AS v ON i.idVeiculo=v.id
                INNER JOIN Veiculo_Utilizador AS vu ON v.id = vu.idVeiculo
            WHERE i.id = :id AND vu.idUtilizador = :userid
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $inspection);
        $stmt->bindValue("userid", LOGIN_DATA["id"]);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            sendErrorMessage(true, "Inspeção inválida (não existe)", "/ProjetoPWBD/customer/");
        }
        $date_diff = date_diff(date_create_from_format("Y-m-d H:i:s", $stmt->fetch()["horaInicio"]), date_create());
        if (!($date_diff->d >= 2 && $date_diff->invert == true)) {
            sendErrorMessage(true, "A data da inspeção está demasiado próxima para serem permitidas modificações", "/ProjetoPWBD/customer");
        }
        $query = "
            DELETE FROM inspecao WHERE id = :id;
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $inspection);
        $stmt->execute();
        sendErrorMessage(false, "Inspeção eliminada", "/ProjetoPWBD/customer/");
    }
    sendErrorMessage(true, "Valores de entrada inválidos", "/ProjetoPWBD/customer/");
?>