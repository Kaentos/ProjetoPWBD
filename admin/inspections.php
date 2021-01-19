<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();

    include("../scripts/php/basedados.h");
    $query = "
        SELECT inspecao.id, inspecao.horaInicio, inspecao.horaFim, veiculo.matricula, linhainspecao.nome linha, 
        inspecao.isDoing, inspecao.isCompleted 
        FROM inspecao 
            INNER JOIN veiculo ON inspecao.idVeiculo=veiculo.id
            INNER JOIN linhainspecao ON inspecao.idLinha=linhainspecao.id
    ";
    $stmt = $dbo->prepare($query);
    $stmt->execute();
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
    <script src="/ProjetoPWBD/assets/js/messages.js"></script>
    <link rel="icon" href="/ProjetoPWBD/assets/img/icon.png">
    <script>
        window.onload = function () {
            <?php
                if (isset($_SESSION["message"])) {
                    echo "showMessageBanner(".json_encode($_SESSION["message"]).")";
                    unset($_SESSION["message"]);
                }
            ?>
        }
    </script>
    <title>CI | Admin - Marcações</title>
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
                            Veículo
                        </th>
                        <th class="u-table-width-100">
                            Linha
                        </th>
                        <th class="u-table-width-50">
                            Status
                        </th>
                        <th class="u-table-width-50">
                            Ações
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        foreach(INSPECTIONS as $inspection) {
                            if ($inspection["isDoing"]) {
                                $status = "Em progresso";
                            } elseif ($inspection["isCompleted"]) {
                                $status = "Completa";
                            } else {
                                $status = "Marcada";
                            }
                            echo "
                                <tr>
                                    <td class='u-table-width-50'>
                                        ".$inspection["id"]."
                                    </td>
                                    <td class='u-table-width-100'>
                                        ".$inspection["horaInicio"]."
                                    </td>
                                    <td class='u-table-width-100'>
                                        ".$inspection["horaFim"]."
                                    </td>
                                    <td class='u-table-width-100'>
                                        ".$inspection["matricula"]."
                                    </td>
                                    <td class='u-table-width-100'>
                                        ".$inspection["linha"]."
                                    </td>
                                    <td class='u-table-width-50'>
                                        ".$status."
                                    </td>
                                    <td class='u-table-width-50'>
                                        <div class='u-table-all-icons'>
                                            <a href='edit_inspection.php?id=".$inspection["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/pencil.png' alt='Editar' srcset=''>
                                            </a>
                                            <a href='remove_inspection.php?id=".$inspection["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/garbage.png' alt='Apagar' srcset=''>
                                            </a>
                                        </div>
                                    </td>
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