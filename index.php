<?php
    session_start();
    if ($_SESSION["login"]) {
        echo "Bom dia - sessão";
        echo "<br>".$_SESSION["login"]."<br>";
    } else if (isset($_COOKIE["login"])) {
        echo "Bom dia - cookie";
        echo "<br>".$_COOKIE["login"]."<br>";
        unset($_COOKIE['login']);
        setcookie('login', '', time() - 3600, '/');
    } else {
        echo "Wtf<br>";
    }
    echo "<br><a href='login.php'>Login</a>";
    session_destroy();
?>