<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfInspectorWithGoto();

    if (isset($_GET["id"])) {
        $getUserID = $_GET["id"];
    }

    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");
    
    $query = "
        SELECT id, nome, email, telemovel, telefone 
        FROM Utilizador
        WHERE id = :id AND idTipo NOT IN (0,1,2);
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindParam("id", $getUserID);
    $stmt -> execute();
    
    if ($stmt -> rowCount() == 1) {
        $user = $stmt -> fetch();
    } else {
        gotoIndex();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/viewData.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/login_register.css">
    <link rel="stylesheet" href="/ProjetoPWBD/assets/css/navbar_footer.css">
    <link rel="icon" href="/ProjetoPWBD/assets/img/icon.png">
    
    <title>
        <?php
            echo "CI | " . $user["nome"];    
        ?>
    </title>
</head>
<body>
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/navbar.php");
    ?>
    <div class="md-zone">
        <br><br>
        <div class="md-panel">
            <h1>
                Consulta de dados
            </h1>
            <div class="md-form">
                <div>
                    <div class="md-inputGroup">
                        <label for="md_name">
                            Nome
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" value='<?php echo $user["nome"] ?>' readonly>
                        </div>
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_email">
                            Email
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" value='<?php echo $user["email"] ?>' readonly>
                        </div>
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_mobile">
                            Nº telemóvel
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" value='<?php echo $user["telemovel"] ?>' readonly>
                        </div>
                    </div>
                    <div class="md-inputGroup">
                        <label for="md_tel">
                            Nº telefone
                        </label>
                        <div class="md-inputGroup-input">
                            <input class="type-input" value='<?php echo ($user["telefone"] != null ? $user["telefone"] : "Não possui") ?>' readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/footer.php");
    ?>
</body>
</html>