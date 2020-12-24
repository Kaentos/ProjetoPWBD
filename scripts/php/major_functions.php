<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/rules.php");
    define("LOGIN_DATA", getLoginData());


    /* Get data */
    function getLoginData() {
        if (isset($_COOKIE["login"])) {
            return json_decode($_COOKIE["login"], true);
        } else if (isset($_SESSION["login"])) {
            return $_SESSION["login"];
        } else {
            return null;
        }
    }



    /* Redirects */
    function gotoIndex() {
        header("location: /ProjetoPWBD/");
        die();
    }

    function gotoListUsers() {
        header("location: /ProjetoPWBD/admin/users.php");
        die();
    }


    /* Checks */
    function checkIfLogged() {
        if (LOGIN_DATA !== null) {
            return true;
        }
        return false;
    }
    function checkIfLoggedWithGoto() {
        if(checkIfLogged()) {
            gotoIndex();
        }
    }

    function checkIfAdmin() {
        if (LOGIN_DATA === null || LOGIN_DATA["type"] != USER_TYPE_ADMIN) {
            return false;
        }
        return true;
    }

    function checkIfAdminWithGoto() {
        if(!checkIfAdmin()) {
            gotoIndex();
        }
    }

    function checkIfInspector() {
        if (LOGIN_DATA === null || LOGIN_DATA["type"] != USER_TYPE_INSPECTOR) {
            return false;
        }
        return true;
    }

    function checkIfClient() {
        if (LOGIN_DATA === null || LOGIN_DATA["type"] != USER_TYPE_CLIENT) {
            return false;
        }
        return true;
    }
?>