<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if(checkIfLogged()) {
        if (isset($_COOKIE["login"])) {
            unset($_COOKIE['login']);
            setcookie('login', '', time() - 3600, '/');
        }
        session_destroy();
    }
    gotoIndex();
?>