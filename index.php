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
    <link rel="icon" href="/ProjetoPWBD/assets/img/icon.png">
    
    <title>Centro de inspeções</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>

    <div class="i-container">

    <div class="i-schedule">
            <div class="i-schedule-title">
                Onde nos encontrar
            </div>
            <div class="map-div">
                <span>
                    Castelo Branco, Beira Interior Sul, Centro, 6000-767, Portugal
                </span>
                <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=-7.524926662445069%2C39.81578841182359%2C-7.514884471893311%2C39.821284869131865&amp;layer=mapnik&amp;marker=39.818536695428236%2C-7.5199055671691895">
                </iframe>
                <br/>
                <a href="https://www.openstreetmap.org/?mlat=39.81854&amp;mlon=-7.51991#map=17/39.81854/-7.51991&amp;layers=N" target="_blank">
                    Abrir no OpenStreetMap
                </a>
            </div>
        </div>

        <div class="i-schedule">
            <div class="i-schedule-title">
                Horário de funcionamento
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
                        <th>
                            Domingo
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
                        <td>
                            Encerrado
                        </td>
                    </tr>
                    <tr>
                        <td>
                            14:00 - 18:00
                        </td>
                        <td>
                            Encerrado
                        </td>
                        <td>
                            Encerrado
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
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
                <tfoot>
                </tfoot>
            </table>
        </div>

    </div>
    
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>