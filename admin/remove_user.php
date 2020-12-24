<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();

    /* Functions */ 
    function showMessage($isError, $msg) {
        $_SESSION["message"] = [
            "isError" => $isError,
            "msg" => $msg
        ];
        gotoListUsers();
    }
    /* END of Functions */

    if(!isset($_GET["id"]) || $_GET["id"] == LOGIN_DATA["id"]) {
        gotoIndex();
    }

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");

    $query = "SELECT id FROM Utilizador WHERE id = :id";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindParam(":id", $_GET["id"]);
    $stmt -> execute();
    if ($stmt -> rowCount() != 1) {
        showMessage(true, "Utilizador não encontrado!");
    }

    if (isset($_GET["perma"]) && $_GET["perma"] == "true") {
        $query = "DELETE FROM Utilizador WHERE id = :id";
    } else {
        $query = "
            UPDATE Utilizador
            SET nome=null, password=null, telemovel=null, telefone=null, isActive=0, isDeleted=1, idTipo=0
            WHERE id = :id;
        ";
    }
    $stmt = $dbo -> prepare($query);
    $stmt -> bindParam(":id", $_GET["id"]);
    $stmt -> execute();
    if ($stmt -> rowCount() == 1) {
        showMessage(false, "Apagou com sucesso!");
    } else {
        showMessage(true, "Não foi possivel apagar!");
    }
?>