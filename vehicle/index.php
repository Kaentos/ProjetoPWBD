<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    if (!checkIfClient()) {
        gotoIndex();
    }

    include("../scripts/php/basedados.h");
    $query = "SELECT veiculo.id, veiculo.matricula, veiculo.ano, veiculo.marca, categoriaveiculo.nome categoria
        FROM veiculo INNER JOIN categoriaveiculo ON veiculo.idCategoria = categoriaveiculo.id
        INNER JOIN veiculo_utilizador ON veiculo.id = veiculo_utilizador.idVeiculo 
        WHERE veiculo_utilizador.idUtilizador = ".LOGIN_DATA["id"].";";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $result = $stmt -> fetchAll();
    define("VEHICLES", $result);
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
                Veículos Registados
            </div>
            <table class="u-table">
                <thead>
                    <tr>
                        <th class="u-table-width-50">
                            ID
                        </th>
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
                                    <th class='u-table-width-50'>
                                        ".$vehicle["id"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$vehicle["matricula"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$vehicle["ano"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$vehicle["marca"]."
                                    </th>
                                    <th class='u-table-width-100'>
                                        ".$vehicle["categoria"]."
                                    </th>
                                    <th class='u-table-width-50'>
                                        <div class='u-table-all-icons'>
                                            <a href='edit.php?id=".$vehicle["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/pencil.png' alt='Editar' srcset=''>
                                            </a>
                                            <a href='../scripts/php/delete_vehicle.php?id=".$vehicle["id"]."'>
                                                <img class='u-table-icon' src='../assets/img/icons/garbage.png' alt='Apagar' srcset=''>
                                            </a>
                                        </div>
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