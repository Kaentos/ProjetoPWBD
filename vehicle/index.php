<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }

    include("../scripts/php/basedados.h");
    $query = "
        SELECT veiculo.id, veiculo.matricula, veiculo.ano, veiculo.marca, categoriaveiculo.nome categoria
        FROM veiculo INNER JOIN categoriaveiculo ON veiculo.idCategoria = categoriaveiculo.id
        INNER JOIN veiculo_utilizador ON veiculo.id = veiculo_utilizador.idVeiculo 
        WHERE veiculo_utilizador.idUtilizador = :userid;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt->bindValue("userid", LOGIN_DATA["id"]);
    $stmt->execute();
    $result = $stmt -> fetchAll();
    define("VEHICLES", $result);
    $query = "
        SELECT inspecao.idVeiculo 
        FROM inspecao AS i
        INNER JOIN veiculo AS v ON i.idVeiculo=v.id
        INNER JOIN veiculo_utilizador AS vu ON v.id=vu.idVeiculo
        WHERE veiculo_utilizador.idUtilizador = :userid;
    ";
    $stmt = $dbo->prepare($query);
    $stmt->bindValue("userid", LOGIN_DATA["id"]);
    $stmt->execute();
    $inspections = array_values($stmt->fetchAll());
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
    <title>CI | Cliente - Veículos</title>
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
                    Veículos Registados
                </div>
                <a href="/ProjetoPWBD/vehicle/new.php">
                    Adicionar
                </a>
            </div>
            <table class="u-table">
                <thead>
                    <tr>
                        <th class="u-table-width-100">
                            Matrícula
                        </th>
                        <th class="u-table-width-100">
                            Ano
                        </th>
                        <th class="u-table-width-100">
                            Marca
                        </th>
                        <th class="u-table-width-100">
                            Categoria
                        </th>
                        <th class="u-table-width-50">
                            Ações
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        foreach(VEHICLES as $vehicle) {
                            echo "
                                <tr>
                                    <td class='u-table-width-100'>
                                        ".$vehicle["matricula"]."
                                    </td>
                                    <td class='u-table-width-100'>
                                        ".$vehicle["ano"]."
                                    </td>
                                    <td class='u-table-width-100'>
                                        ".$vehicle["marca"]."
                                    </td>
                                    <td class='u-table-width-100'>
                                        ".$vehicle["categoria"]."
                                    </td>
                                    <td class='u-table-width-50'>
                                        <div class='u-table-all-icons'>
                            ";
                            if (!in_array($vehicle["id"], $inspections)) {
                                echo "
                                            <a href='../customer/new.php?id=".$vehicle["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/notebook.png' alt='Marcar Inspeção' title='Marcar Inspeção' srcset=''>
                                            </a>
                                ";
                            }
                            echo "
                                            <a href='edit.php?id=".$vehicle["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/pencil.png' alt='Editar' srcset=''>
                                            </a>
                                            <a href='../scripts/php/delete_vehicle.php?id=".$vehicle["id"]."'>
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