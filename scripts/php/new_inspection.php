<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }
    if (isset($_POST["ni_startdate"]) && isset($_POST["ni_starttime"]) && isset($_POST["ni_cat"])) {
        $ni = array(
            "startdt" => date_create_from_format("Y-m-d-H:i", $_POST["ni_startdate"]."-".$_POST["ni_starttime"]),
            "cat" => $_POST["ni_cat"]
        );
        if ($ni["startdt"] === false) {
            die("Invalid DateTime");
        } else {
            die(date_format($ni["startdt"], "Y-m-d-H:i"));
        }
        $query = "INSERT INTO inspecao (horaInicio, idCliente, ) VALUES";
    }
?>