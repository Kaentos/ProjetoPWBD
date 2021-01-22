<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfInspectorWithGoto();

    include("../scripts/php/basedados.h");

    $query = "
        SELECT idLinha
        FROM LinhaInspecao_Utilizador
        WHERE idUtilizador = :id;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindValue("id", LOGIN_DATA["id"]);
    $stmt -> execute();
    $result = $stmt -> fetch();
    $idLinha = $result["idLinha"];

    $query = "
        SELECT li.id, li.nome, li.idCategoria, cv.nome AS categoria
        FROM LinhaInspecao AS li
        INNER JOIN CategoriaVeiculo AS cv on li.idCategoria = cv.id
        WHERE li.id = :id;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindValue("id", $idLinha);
    $stmt -> execute();
    $infoLinha = $stmt -> fetch();

    $query_date = "
        SELECT i.id, i.horaInicio, i.horaFim, i.isDoing, i.isCompleted, v.matricula, v.marca, u.nome, u.id AS userID
        FROM inspecao AS i
            INNER JOIN veiculo as v ON i.idVeiculo = v.id
            INNER JOIN veiculo_utilizador AS vu ON v.id = vu.idVeiculo 
            INNER JOIN utilizador as u ON vu.idUtilizador = u.id
        WHERE i.idLinha = :idLinha AND DATE(i.horaInicio) = :date;
    ";
    $stmt = $dbo -> prepare($query_date);
    $date = false;
    if (isset($_GET["date"])) {
        $date = date_create_from_format("Y-m-d", $_GET["date"]);
        if ($date !== false) {
            $stmt -> bindValue("date", $date->format("Y-m-d"));
        } else {
            $stmt -> bindValue("date", date("Y-m-d"));
        }
    } else {
        $stmt -> bindValue("date", date("Y-m-d"));
    }
    $stmt -> bindValue("idLinha", $idLinha);
    $stmt -> execute();
    $allInspections = $stmt -> fetchAll();
    define("ALL_INSPECTIONS", $allInspections);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/listInspections.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/filterdate.css">
    <link rel="icon" href="/ProjetoPWBD/assets/img/icon.png">
    <script src="/ProjetoPWBD/assets/js/messages.js"></script>
    <title>CI | Inspector - Inspeções</title>
    <script>
        window.onload = function() {
            <?php
                if (isset($_SESSION["message"])) {
                    echo "showMessageBanner(".json_encode($_SESSION["message"]).");";
                    unset($_SESSION["message"]);
                }
            ?>
        }
    </script>
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
                <div>
                    <?php
                        if ($date !== false) {
                            echo "Inspeções de ".$date->format("d/m/Y");
                        } else {
                            echo "Inspeções de hoje";
                        }
                    ?>
                </div>
                <div style="text-align: right;">
                    Linha:
                    <?php
                        echo $infoLinha["id"] . " - " . $infoLinha["nome"] ." (". $infoLinha["categoria"].")";
                    ?>
                    <br>
                    <form action="list.php" method="get">
                        <input type="date" class="fd-input" name="date">
                        <input class="fd-inputBtn" type="submit" value="Consultar" id="editBtn">
                    </form>
                </div>
            </div>
            <table class="u-table">
                <thead>
                    <tr>
                        <th class="u-table-width-100">
                            Hora inicio
                        </th>
                        <th class="u-table-width-100">
                            Hora fim
                        </th>
                        <th class="u-table-width-100">
                            Matricula
                        </th>
                        <th class="u-table-width-150">
                            Marca
                        </th>
                        <th class="u-table-width-75">
                            Cliente
                        </th>
                        <th class="canWrap u-table-width-100">
                            Estado
                        </th><th class="canWrap u-table-width-50">
                            Ação
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        if (count(ALL_INSPECTIONS) == 0 ) {
                            echo "
                                <tr>
                                    <td colspan='8'>Não há inspeções para a data selecionada</td>
                                </tr>
                            ";
                        }
                        foreach(ALL_INSPECTIONS as $inspection) {
                            echo "
                                <tr>
                                    <td class='u-table-width-50' title='".$inspection["horaInicio"]."'>
                                        ".$inspection["horaInicio"]."
                                    </td>
                                    <td class='u-table-width-125' title='".$inspection["horaFim"]."'>
                                        ".$inspection["horaFim"]."
                                    </td>
                                    <td class='u-table-width-100' title='".$inspection["matricula"]."'>
                                        ".$inspection["matricula"]."
                                    </td>
                                    <td class='u-table-width-150' title='".$inspection["marca"]."'>
                                        ".$inspection["marca"]."
                                    </td>
                                    <td class='u-table-width-100' title='".$inspection["nome"]."'>
                                        <a href='/ProjetoPWBD/customer/viewData.php?id=".$inspection["userID"]."'>
                                            ".$inspection["nome"]."
                                        </a>
                                    </td>
                                    <td class='u-table-width-100'>
                            ";
                            if ($inspection["isDoing"] == false && $inspection["isCompleted"] == false) {
                                echo "
                                        ".($inspection["isDoing"] ? "Em progresso" : "Não começou" )."
                                    </td>
                                ";
                            } else {
                                echo "
                                        ".($inspection["isCompleted"] ? "Completada" : "A inspecionar..." )."
                                    </td>
                                ";
                            }
                                    
                            echo "
                                    <td class='u-table-width-100'>
                                        <div class='u-table-all-icons'>
                            ";
                            if ($inspection["isDoing"] == true) {
                                if ($inspection["isCompleted"] == false) {
                                    echo "
                                        <a href='manageInspection.php?id=".$inspection["id"]."&action=finish'>
                                            Completar
                                        </a>
                                    ";
                                }
                            } else if ($inspection["isCompleted"] == false) {
                                echo "
                                    <a href='manageInspection.php?id=".$inspection["id"]."&action=doing'>
                                        Começar
                                    </a>
                                ";
                            }
                            echo "
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