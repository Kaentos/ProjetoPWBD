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

    if(!isset($_GET["id"]))
        showMessage(true, "ID de utilizador inválido!");
    if($_GET["id"] == LOGIN_DATA["id"])
        showMessage(true, "Não pode manipular a si mesmo nesta página!");

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");

    $query = "SELECT id FROM Utilizador WHERE id = :id";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindParam(":id", $_GET["id"]);
    $stmt -> execute();
    if ($stmt -> rowCount() != 1) {
        showMessage(true, "Utilizador (ID: ".$_GET["id"].") não encontrado!");
    }
    $result = $stmt -> fetch();
    $userID = $result["id"];

    if (isset($_GET["perma"]) && $_GET["perma"] === "true") {
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
        showMessage(false, "Apagou ".($_GET["perma"] === "true" ? "permanente" : "")." o utilizador (ID: $userID) com sucesso!");
    } else {
        showMessage(true, "Não foi possivel apagar ".($_GET["perma"] === "true" ? "permanente" : "")." o utilizador (ID: $userID)!");
    }
?>