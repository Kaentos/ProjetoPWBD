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
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/utilizadores.css">
    <script>
        window.onload = function() {
            activateLiveCheckLogin();
            <?php
                if (isset($_SESSION["badLogin"])) {
                    echo "badLogin('".$_SESSION["badLogin"]."')";
                    unset($_SESSION["badLogin"]);
                }
            ?>
        }
    </script>
    
    <title>CI | Admin - Utilizadores</title>
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT']."/ProjetoPWBD/navbar.php");
    ?>
    
    <div class="u-zone">
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
                    <tr>
                        <th class="u-table-width-50">
                            1233
                        </th>
                        <th class="u-table-width-150">
                            Alexandre Bnanassadoibsandiosbdiosabsio
                        </th>
                        <th class="u-table-width-100">
                            Username
                        </th>
                        <th class="u-table-width-200">
                            alexandrebananas@gmail.comsadbsadsabodbasoidi
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="canWrap u-table-width-125">
                            2020-13-13 13:13:13
                        </th>
                        <th class="u-table-width-50">
                            Sim
                        </th>
                        <th class="u-table-width-50">
                            Não
                        </th>
                        <th class="u-table-width-100">
                            Cliente
                        </th>
                        <th class="u-table-width-100">
                            <div class="u-table-all-icons">
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/x-times.png" alt="Tirar acesso" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/pencil.png" alt="Editar" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/garbage.png" alt="Apagar" srcset="">
                                </a>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="u-table-width-50">
                            1233
                        </th>
                        <th class="u-table-width-150">
                            Alexandre Bnanassadoibsandiosbdiosabsio
                        </th>
                        <th class="u-table-width-100">
                            Username
                        </th>
                        <th class="u-table-width-200">
                            alexandrebananas@gmail.comsadbsadsabodbasoidi
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="canWrap u-table-width-125">
                            2020-13-13 13:13:13
                        </th>
                        <th class="u-table-width-50">
                            Sim
                        </th>
                        <th class="u-table-width-50">
                            Não
                        </th>
                        <th class="u-table-width-100">
                            Cliente
                        </th>
                        <th class="u-table-width-100">
                            <div class="u-table-all-icons">
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/x-times.png" alt="Tirar acesso" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/pencil.png" alt="Editar" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/garbage.png" alt="Apagar" srcset="">
                                </a>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="u-table-width-50">
                            1233
                        </th>
                        <th class="u-table-width-150">
                            Alexandre Bnanassadoibsandiosbdiosabsio
                        </th>
                        <th class="u-table-width-100">
                            Username
                        </th>
                        <th class="u-table-width-200">
                            alexandrebananas@gmail.comsadbsadsabodbasoidi
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="canWrap u-table-width-125">
                            2020-13-13 13:13:13
                        </th>
                        <th class="u-table-width-50">
                            Sim
                        </th>
                        <th class="u-table-width-50">
                            Não
                        </th>
                        <th class="u-table-width-100">
                            Cliente
                        </th>
                        <th class="u-table-width-100">
                            <div class="u-table-all-icons">
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/x-times.png" alt="Tirar acesso" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/pencil.png" alt="Editar" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/garbage.png" alt="Apagar" srcset="">
                                </a>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="u-table-width-50">
                            1233
                        </th>
                        <th class="u-table-width-150">
                            Alexandre Bnanassadoibsandiosbdiosabsio
                        </th>
                        <th class="u-table-width-100">
                            Username
                        </th>
                        <th class="u-table-width-200">
                            alexandrebananas@gmail.comsadbsadsabodbasoidi
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="u-table-width-125">
                            213123123
                        </th>
                        <th class="canWrap u-table-width-125">
                            2020-13-13 13:13:13
                        </th>
                        <th class="u-table-width-50">
                            Sim
                        </th>
                        <th class="u-table-width-50">
                            Não
                        </th>
                        <th class="u-table-width-100">
                            Cliente
                        </th>
                        <th class="u-table-width-100">
                            <div class="u-table-all-icons">
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/x-times.png" alt="Tirar acesso" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/pencil.png" alt="Editar" srcset="">
                                </a>
                                <a href="/">
                                    <img class="u-table-icon" src="../assets/img/icons/garbage.png" alt="Apagar" srcset="">
                                </a>
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer id="footer"></footer>
</body>
</html>