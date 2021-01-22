<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfInspectorWithGoto();

    if ( isset($_GET["id"]) && isset($_GET["action"]) ) {
        include("../scripts/php/basedados.h");

        $query = "
            SELECT *
            FROM Inspecao
            WHERE id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $_GET["id"]);
        $stmt -> execute();
        if ($stmt -> rowCount() != 1) {
            sendErrorMessage(true, "Inspeção Inválida", "list.php");
        }

        $action = $_GET["action"];
        if (strcmp($action, "doing") == 0) {
            $infoInspecao = $stmt -> fetch();
            $horaInicio = new DateTime(date("Y-m-d H:i:s", strtotime($infoInspecao["horaInicio"])));
            $horaAtual = new DateTime(date("Y-m-d H:i:s"));
            $horaAtual -> add(new DateInterval('PT15M'));
            if ( $horaInicio > $horaAtual ) {
                showMessage(true, "Ainda não pode começar a inspeção!");
            }
            $query = "
                UPDATE Inspecao
                SET isDoing = 1
                WHERE id = :id;
            ";
        } else {
            $query = "
                UPDATE Inspecao
                SET isDoing = 0, isCompleted = ". (strcmp($_GET["action"], "finish") == 0 ? "1" : "0" ) ."
                WHERE id = :id;
            ";    
        }
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $_GET["id"]);
        $stmt -> execute();

        if (strcmp($action, "doing") == 0) {
            showMessage(false, "Começou a inspecionar");
        } else {
            showMessage(false, "Completou a inspeção!");
        }

        
        header("location: list.php");
        die();
    }

    function showMessage($isError, $msg) {
        $_SESSION["message"] = [
            "isError" => $isError,
            "msg" => $msg
        ];
        header("location: list.php");
        die();
    }


?>