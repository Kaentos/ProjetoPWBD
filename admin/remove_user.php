<?php
    session_start();
    include("../scripts/php/rules.php");
    if (!isset($_SESSION["login"]) && $_SESSION["login"]["id"] === USER_TYPE_ADMIN) {
        header("location: ../");
        die();
    }

    include("../scripts/php/basedados.h");
    $query = "SELECT Utilizador.id, Utilizador.nome, username, email, telemovel, telefone, dataCriacao, isActive, isDeleted, TipoUtilizador.nome as nomeTipo FROM Utilizador INNER JOIN TipoUtilizador ON idTipo = TipoUtilizador.id";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $result = $stmt -> fetchAll();
    define("ALL_USERS", $result);

?>