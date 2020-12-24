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


    if (isset($_GET["action"])) {
        if ($_GET["action"] === "give") {
            $isActive = 1;
        } else if ($_GET["action"] === "remove") {
            $isActive = 0;
        } else {
            showMessage(true, "Ação inválida!");
        }
    } else {
        showMessage(true, "Ação inválida!");
    }
    $query = "UPDATE Utilizador SET isActive=:isActive WHERE id = :id";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindParam(":isActive", $isActive);
    $stmt -> bindParam(":id", $_GET["id"]);
    $stmt -> execute();
    if ($stmt -> rowCount() == 1) {
        showMessage(false, ($isActive ? "Deu acesso" : "Removeu acesso" ) . " ao utilizador (ID: $userID) com sucesso!");
    } else {
        showMessage(true, "Não foi gerir o acesso do utilizador (ID: $userID)!");
    }
?>