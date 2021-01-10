<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/contact.css">
    
    <title>CI | Contacto</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>

    <div class="c-container">

        <div class="c-info">
            <div class="c-info-title">
                Contacto
            </div>
            <div class="c-info-desc">
                Caso possua alguma dúvida ou tenha encontrado um problema no sítio web por favor contacte os administradores.
                Poderá fazer o contacto através de email ou chamada.<br>
                <b>Por favor indique o assunto no email!</b>
            </div>
            <table class="c-info-table">
                <thead>
                    <tr>
                        <th>
                            Nome
                        </th>
                        <th>
                            Email
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            André Duarte
                        </td>
                        <td>
                            andre.duarte@ipcbcampus.pt
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Miguel Magueijo
                        </td>
                        <td>
                            m.magueijo@ipcbcampus.pt
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="c-info-table-footer">
                <b>Tempo de resposta:</b>
                Até 48 horas 
            </div>

            <table class="c-info-table">
                <thead>
                    <tr>
                        <th>
                            Telefone
                        </th>
                        <th>
                            Telemóvel
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            (+351) 275751123
                        </td>
                        <td>
                            (+351) 921322123
                        </td>
                    </tr>
                </tbody>
                    
            </table>
            <div class="c-info-table-footer">
                <b>Horário de atendimento:</b><br>
                <b>Segunda a sexta-feira:</b> 9:00 - 13:00 / 14:00 - 18:00<br>
                <b>Sábado: 9:00 - 13:00</b><br>
                <b>Domingo:</b> Indisponivel
            </div>
                
        </div>

    </div>
    
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>