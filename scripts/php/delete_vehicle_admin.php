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
            die("Veiculo invalido (não existe)");
        }
        header("Location: /ProjetoPWBD/admin/vehicles.php");
        die();
    } else {
        header("Location: /ProjetoPWBD/admin/vehicles.php");
        die();
    }
?>