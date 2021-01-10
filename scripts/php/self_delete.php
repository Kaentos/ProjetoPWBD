<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfNotLoggedWithGoto();

    if (isset($_POST["md_delete_pwd"]) && isset($_POST["md_delete_confirm"])) {
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");

        if (strcmp($_POST["md_delete_confirm"], "confirm") != 0) {
            showErrorValue(10, "Para apagar precisa de aceitar os termos");
        }

        $query = "
            SELECT *
            FROM utilizador
            WHERE id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $userID = LOGIN_DATA["id"];
        $stmt -> bindParam("id", $userID);
        $stmt -> execute();
        if ($stmt -> rowCount() == 1) {
            $user = $stmt -> fetch();
            if (password_verify($_POST["md_delete_pwd"], $user["password"])) {
                if ($user["idTipo"] == USER_TYPE_ADMIN) {
                    $query = "
                        SELECT count(id) AS totalAdmins
                        FROM utilizador
                        WHERE idTipo = ".USER_TYPE_ADMIN."
                    ";
                    $stmt = $dbo -> prepare($query);
                    $stmt -> execute();
                    $totalAdmins = $stmt -> fetch();
                    if ($totalAdmins["totalAdmins"] == 1) {
                        showErrorValue(-1, "É o unico admin, não se pode apagar!");
                    }
                }

                $query = "
                    UPDATE Utilizador
                    SET nome=null, password=null, telemovel=null, telefone=null, isActive=0, isDeleted=1, idTipo=0
                    WHERE id = :id;
                ";
                $stmt = $dbo -> prepare($query);
                $stmt -> bindParam("id", $user["id"]);
                $stmt -> execute();
            } else {
                showErrorValue(9, "Palavra-passe errada");
            }
        }
        unset($userID);
        gotoLogout();

    } else {
        if (!isset($_POST["md_delete_confirm"])) {
            showErrorValue(10, "Para apagar precisa de aceitar os termos");
        }
        gotoIndex();
    }

    function showErrorValue($code, $reason) {
        $_SESSION["badMyData"] = [
            "code" => $code,
            "reason" => $reason
        ];
        gotoMyData();
    }
?>