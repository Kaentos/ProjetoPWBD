<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/rules.php");
    define("LOGIN_DATA", getLoginData());

    /* For PHP < 7.3 */
    if (! function_exists("array_key_last")) {
        function array_key_last($array) {
            if (!is_array($array) || empty($array)) {
                return NULL;
            }
           
            return array_keys($array)[count($array)-1];
        }
    }


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

    function gotoRegister() {
        header("location: /ProjetoPWBD/register.php");
        die();
    }

    function gotoListUsers() {
        header("location: /ProjetoPWBD/admin/users.php");
        die();
    }

    function gotoAddUser() {
        header("location: /ProjetoPWBD/admin/add_user.php");
        die();
    }

    function gotoMyData() {
        header("location: /ProjetoPWBD/mydata.php");
        die();
    }

    function gotoEditUser($id) {
        header("location: /ProjetoPWBD/admin/edit_user.php?id=" . $id);
        die();
    }

    function gotoLogout() {
        header("location: /ProjetoPWBD/logout.php");
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
    function checkIfNotLoggedWithGoto() {
        if(!checkIfLogged()) {
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

    function checkIfInspectorWithGoto() {
        if(!checkIfInspector()) {
            gotoIndex();
        }
    }

    function checkIfClient() {
        if (LOGIN_DATA === null || LOGIN_DATA["type"] != USER_TYPE_CLIENT) {
            return false;
        }
        return true;
    }

    function checkIfClientWithGoto() {
        if(!checkIfClient()) {
            gotoIndex();
        }
    }
?>