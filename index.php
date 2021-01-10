<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/index.css">
    
    <title>Centro de inspeções</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>

    <div class="i-container">

        <div class="i-schedule">
            <div class="i-schedule-title">
                Horário
            </div>
            <table class="i-schedule-table">
                <thead>
                    <tr>
                        <th>
                            Segunda a Sexta-feira
                        </th>
                        <th>
                            Sábado
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            9:00 - 13:00
                        </td>
                        <td>
                            9:00 - 13:00
                        </td>
                    </tr>
                    <tr>
                        <td>
                            14:00 - 18:00
                        </td>
                        <td>
                            Encerrado
                        </td>
                    </tr>
                </tbody>
                <tfooter>
                </tfooter>
            </table>
        </div>

        <div class="i-prices">
            <div class="i-prices-title">
                Tabela de preços
            </div>
            <table class="i-prices-table">
                <thead>
                    <tr>
                        <th>
                            Categoria veículo
                        </th>
                        <th>
                            Preço
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Ligeiro de passageiros
                        </td>
                        <td>
                            30€
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Motociclo
                        </td>
                        <td>
                            15€
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Pesado de mercadorias
                        </td>
                        <td>
                            50€
                        </td>
                    </tr>
                </tbody>
                <tfooter>
                </tfooter>
            </table>
        </div>

    </div>
    
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>