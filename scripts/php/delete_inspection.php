<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_GET["id"])) {
        
        $inspection = $_GET["id"];
        include("basedados.h");
        $query = "
            SELECT i.id
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
            header("Location: /ProjetoPWBD/customer/");
            die();
        }
        $query = "
            DELETE FROM inspecao WHERE id = :id;
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $inspection);
        $stmt->execute();
        header("Location: /ProjetoPWBD/customer");
        die();
    }
    header("Location: /ProjetoPWBD/customer");
    die();
?>