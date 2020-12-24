<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/index_admin.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar.css">
    <title>CI | Admin - Utilizadores</title>
</head>
<body>
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/navbar.php");
    ?>
    <div class="ia-zone">
        <div class="ia-panel">
            <div class="ia-title">
                Painel de controlo
            </div>
            <br>
            <div class="ia-list">
                <a class="ia-item" href="users.php">
                    <img src="/ProjetoPWBD/assets/img/icons/user.png">
                    <br>
                    Utilizadores
                </a>
                <a class="ia-item" href="users.php">
                    <img src="/ProjetoPWBD/assets/img/icons/user.png">
                    <br>
                    Tipos de Utilizador
                </a>
                <a class="ia-item" href="users.php">
                    <img src="/ProjetoPWBD/assets/img/icons/car.png">
                    <br>
                    Marcações
                </a>
                <a class="ia-item" href="users.php">
                    <img src="/ProjetoPWBD/assets/img/icons/car.png">
                    <br>
                    Linhas
                </a>
                <a class="ia-item" href="users.php">
                    <img src="/ProjetoPWBD/assets/img/icons/car.png">
                    <br>
                    Categoria de veículos
                </a>
            </div>
            <br>
        </div>
        
    </div>
    <footer id="footer"></footer>
</body>
</html>

