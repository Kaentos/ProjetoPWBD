<?php
    session_start();
    if (!isset($_SESSION["login"]) && !$_COOKIE["login"]) {
        header("location: ../");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar.css">
    <title>CI | Admin - Utilizadores</title>
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT']."/ProjetoPWBD/navbar.php");
    ?>
    <a href="utilizadores.php">Utilizadores</a>
    <footer id="footer"></footer>
</body>
</html>

