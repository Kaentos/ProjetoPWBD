<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();

    if (isset($_GET["id"]) && $_GET["id"] != LOGIN_DATA["id"]) {

    } else {
        gotoIndex();
    }
?>