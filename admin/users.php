<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();

    include("../scripts/php/basedados.h");
    $query = "
        SELECT Utilizador.id, Utilizador.nome, username, email, telemovel, telefone, dataCriacao, isActive, isDeleted, TipoUtilizador.nome as nomeTipo
        FROM Utilizador INNER JOIN TipoUtilizador ON idTipo = TipoUtilizador.id
        ORDER BY Utilizador.id;";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $result = $stmt -> fetchAll();
    define("ALL_USERS", $result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/users.css">
    <script src="/ProjetoPWBD/assets/js/users.js"></script>
    <script>
        window.onload = function () {
            <?php
                if (isset($_SESSION["message"])) {
                    echo "showMessage(".json_encode($_SESSION["message"]).")";
                    unset($_SESSION["message"]);
                }
            ?>
        }
    </script>
    <title>CI | Admin - Utilizadores</title>
</head>
<body>
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/navbar.php");
    ?>
    
    <div class="u-zone">
        <div class="message" id="message">
            ERRO
        </div>

        <div class="u-panel">
            <div class="u-title">
                Utilizadores
            </div>
            <table class="u-table">
                <thead>
                    <tr>
                        <th class="u-table-width-50">
                            ID
                        </th>
                        <th class="u-table-width-150">
                            Nome
                        </th>
                        <th class="u-table-width-100">
                            Username
                        </th>
                        <th class="u-table-width-200">
                            Email
                        </th>
                        <th class="u-table-width-125">
                            Telemovel
                        </th>
                        <th class="u-table-width-125">
                            Telefone
                        </th>
                        <th class="canWrap u-table-width-125">
                            Data Criação
                        </th>
                        <th class="u-table-width-50">
                            Ativo?
                        </th>
                        <th class="u-table-width-50">
                            Apagado?
                        </th>
                        <th class="u-table-width-100">
                            Tipo
                        </th>
                        <th class="u-table-width-100">
                            Ações
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        foreach(ALL_USERS as $user) {
                            echo "
                                <tr>
                                    <th class='u-table-width-50'>
                                        ".$user["id"]."
                                    </th>
                                    <th class='u-table-width-150'>
                                        ".$user["nome"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$user["username"]."
                                    </th>
                                    <th class='u-table-width-200'>
                                        ".$user["email"]."
                                    </th>
                                    <th class='u-table-width-125'>
                                        ".$user["telemovel"]."
                                    </th>
                                    <th class='u-table-width-125'>
                                        ".$user["telefone"]."
                                    </th>
                                    <th class='canWrap u-table-width-125'>
                                        ".$user["dataCriacao"]."
                                    </th>
                                    <th class='u-table-width-50'>
                                        ".($user["isActive"] ? "SIM" : "NÃO")."
                                    </th>
                                    <th class='u-table-width-50'>
                                        ".($user["isDeleted"] ? "SIM" : "NÃO")."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$user["nomeTipo"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        <div class='u-table-all-icons'>
                                    ";
                                    if ($user["id"] !== LOGIN_DATA["id"]) {
                                        echo "
                                            <a href='edit_user.php?id=".$user["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/pencil.png' alt='Editar' srcset=''>
                                            </a>
                                        ";
                                        if (!$user["isDeleted"]) {
                                            if ($user["isActive"]) {
                                                echo "
                                                    <a href='manage_access_user.php?id=".$user["id"]."&action=remove'>
                                                        <img class='u-table-icon' src='../assets/img/icons/dislike.png' alt='Tirar acesso' srcset=''>
                                                    </a>
                                                ";
                                            } else {
                                                echo "
                                                    <a href='manage_access_user.php?id=".$user["id"]."&action=give'>
                                                        <img class='u-table-icon' src='../assets/img/icons/like.png' alt='Aprovar' title='Aprovar'>
                                                    </a>
                                                ";
                                            }
                                            echo "
                                                <a href='remove_user.php?id=".$user["id"]."'>
                                                    <img class='u-table-icon' src='../assets/img/icons/garbage.png' alt='Apagar' srcset=''>
                                                </a>
                                            ";
                                        } else {
                                            echo "
                                                <a class='red-icon' href='remove_user.php?id=".$user["id"]."&perma=true'>
                                                    <img class='u-table-icon' src='../assets/img/icons/garbage.png' alt='Apagar' srcset=''>
                                                </a>
                                            ";
                                        }
                                        echo "
                                                </th>
                                            </tr>
                                        ";
                                    }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>