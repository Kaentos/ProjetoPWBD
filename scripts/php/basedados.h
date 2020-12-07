<?php
    define("DB_SERVER", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "CentroInspecoes");
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
    if (mysqli_connect_errno($conn)) {
        echo "Erro a conectar à base de dados."; // . mysqli_connect_errno($conn) . " " . mysqli_connect_error($conn);
        exit();
    }
?>