<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();
    if (isset($_GET["id"])) {
        
        $inspection = $_GET["id"];
        include("basedados.h");
        $query = "
            SELECT i.id
            FROM inspecao AS i
                INNER JOIN veiculo AS v ON i.idVeiculo=v.id
                INNER JOIN Veiculo_Utilizador AS vu ON v.id = vu.idVeiculo
            WHERE i.id = :id
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $inspection);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            header("Location: inspections.php");
            die();
        }
        $query = "
            DELETE FROM inspecao WHERE id = :id;
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $inspection);
        $stmt->execute();
        header("Location: inspections.php");
        die();
    }
    header("Location: inspections.php");
    die();
?>