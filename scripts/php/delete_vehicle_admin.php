<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        include("basedados.h");
        $query = "DELETE FROM veiculo WHERE id = :id";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            sendErrorMessage(true, "Veículo inválido (não existe)", "/ProjetoPWBD/admin/vehicles.php");
        }
        sendErrorMessage(false, "Veículo eliminado", "/ProjetoPWBD/admin/vehicles.php");
    } else {
        sendErrorMessage(true, "Valores de entrada inválidos", "/ProjetoPWBD/admin/vehicles.php");
    }
?>