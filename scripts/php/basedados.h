<?php
    define("DB_SERVER", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "CentroInspecoes");
    try {
        $dbo = new PDO("mysql:host=". DB_SERVER .";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo "Erro a conectar à base de dados.";
        die();
    }
?>