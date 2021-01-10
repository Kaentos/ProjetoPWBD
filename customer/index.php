<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }

    include("../scripts/php/basedados.h");
    $query = "SELECT * FROM inspecao WHERE idCliente = ".LOGIN_DATA["id"].";";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $result = $stmt -> fetchAll();
    define("INSPECTIONS", $result);
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
    <title>CI | Cliente - Marcações</title>
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
                Marcações
            </div>
            <table class="u-table">
                <thead>
                    <tr>
                        <th class="u-table-width-50">
                            ID
                        </th>
                        <th class="u-table-width-100">
                            Hora de Inicio
                        </th>
                        <th class="u-table-width-100">
                            Hora de Fim
                        </th>
                        <th class="u-table-width-100">
                            ID de Linha
                        </th>
                        <th class="u-table-width-100">
                            ID de Inspetor
                        </th>
                        <th class="u-table-width-50">
                            Ações
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        foreach(INSPECTIONS as $inspection) {
                            $id_inspetor = $inspection["idInspetor"] !== NULL ? $inspection["idInspetor"] : "Por atribuir";
                            $id_linha = $inspection["idLinha"] !== NULL ? $inspection["idLinha"] : "Por atribuir";
                            echo "
                                <tr>
                                    <th class='u-table-width-50'>
                                        ".$inspection["id"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$inspection["horaInicio"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$inspection["horaFim"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$id_linha."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$id_inspetor."
                                    </th>
                                    <th class='u-table-width-50'>
                                        <div class='u-table-all-icons'>
                                    ";
                                    if ($id_inspetor !== NULL) {
                                        echo "
                                            <a href='edit_user.php?id=".$inspection["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/pencil.png' alt='Editar' srcset=''>
                                            </a>
                                        ";
                                    }
                                    echo "
                                        <a href='remove_user.php?id=".$inspection["id"]."'>
                                            <img class='u-table-icon' src='../assets/img/icons/garbage.png' alt='Apagar' srcset=''>
                                        </a>
                                        ";
                                    echo "
                                        </th>
                                        </tr>
                                        ";
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