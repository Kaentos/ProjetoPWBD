<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfAdminWithGoto();

    if ( isset($_POST["eu_id"]) && isset($_POST["eu_username"]) && isset($_POST["eu_email"]) && isset($_POST["eu_name"]) && isset($_POST["eu_mobile"]) && isset($_POST["eu_tel"]) && isset($_POST["eu_userType"]) ) {
        if ($_POST["eu_userType"] == USER_TYPE_DELETED) {
            showErrorValue(8, "Utilizador não pode ser do tipo apagado!");
            gotoEditUser($_POST["eu_id"]);
        }
        
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");

        $user = array(
            "id" => $_POST["eu_id"],
            "username" => $_POST["eu_username"],
            "email" => $_POST["eu_email"],
            "nome" => $_POST["eu_name"],
            "telemovel" => $_POST["eu_mobile"],
            "telefone" => strlen($_POST["eu_tel"]) == 0 ?  null : $_POST["eu_tel"],
            "dataEdicao" => date("Y/m/d H:i:s"),
            "idTipo" => $_POST["eu_userType"]
        );

        $editColumns = "SET isDeleted = false, nome = :nome, username = :username, email = :email, telemovel = :telemovel, telefone = :telefone, dataEdicao = :dataEdicao, idTipo = :idTipo";

        if ( isset($_POST["eu_pwd"]) && isset($_POST["eu_pwd2"]) ) {
            if ( preg_match(REGEX_PWD, $_POST["eu_pwd"]) && strcmp($_POST["eu_pwd"], $_POST["eu_pwd2"] ) == 0 ) {
                $editColumns = $editColumns . ", password = :password";
                $user["password"] = password_hash($_POST["eu_pwd"], PASSWORD_BCRYPT, ["cost" => 12]);
            } 
        }

        if ( !preg_match(REGEX_USERNAME, $user["username"]) ) {
            showErrorValue(1, "Username inválido");
            gotoEditUser($user["id"]);
        } else {
            $query = "
                SELECT id 
                FROM Utilizador
                WHERE username = :username AND id != :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindParam("username", $user["username"]);
            $stmt -> bindParam("id", $user["id"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                showErrorValue(1, "Username (" . $user["username"] . ") já existe");
                gotoEditUser($user["id"]);
            }
        }

        if ( !preg_match(REGEX_EMAIL, $user["email"]) ) {
            showErrorValue(2, "Email inválido");
            gotoEditUser($user["id"]);
        } else {
            $query = "
                SELECT id 
                FROM Utilizador
                WHERE email = :email AND id != :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindParam("email", $user["email"]);
            $stmt -> bindParam("id", $user["id"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                showErrorValue(2, "Email (" . $user["email"] . ") já existe");
                gotoEditUser($user["id"]);
            }
        }

        if ( !preg_match(REGEX_NAME, $user["nome"]) ) {
            showErrorValue(5, "Nome de utilizador inválido");
            gotoEditUser($user["id"]);
        }

        if ( !preg_match(REGEX_CONTACTNUMBER, $user["telemovel"]) ) {
            showErrorValue(6, "Nº de telemóvel inválido");
            gotoEditUser($user["id"]);
        }

        if ($user["telefone"] != null && !preg_match(REGEX_CONTACTNUMBER, $user["telefone"]) ) {
            showErrorValue(7, "Número de telefone inválido");
            gotoEditUser($user["id"]);
        }

        $query = "
            UPDATE Utilizador
            ". $editColumns ."
            WHERE id = :id
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($user);
        if ($stmt -> rowCount() == 0) {
            showMessage(true, "Não foi possivel alterar o utilizador (ID: ".$user["id"].")");
            gotoListUsers();
        }


        if ( isset($_POST["eu_linha"]) && $user["idTipo"] == USER_TYPE_INSPECTOR ) {
            if ($_POST["eu_linha"] == -100) {
                showErrorValue(9, "Não selecionou uma linha de inspeção!");
                gotoEditUser($user["id"]);
            }

            $query = "
                SELECT *
                FROM LinhaInspecao_Utilizador
                WHERE idUtilizador = :id
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("id", $user["id"]);
            $stmt -> execute();
            if ($stmt -> rowCount() == 1) {
                $query = "
                    UPDATE LinhaInspecao_Utilizador
                    SET idLinha = :idLinha
                    WHERE idUtilizador = :id;
                ";
                $stmt = $dbo -> prepare($query);
                $stmt -> bindValue("idLinha", $_POST["eu_linha"]);
                $stmt -> bindValue("id", $user["id"]);
                $stmt -> execute();
            } else {
                $query = "INSERT INTO LinhaInspecao_Utilizador VALUES (:idLinha, :idUtilizador);";
                $stmt = $dbo -> prepare($query);
                $stmt -> bindValue("idLinha", $_POST["eu_linha"]);
                $stmt -> bindValue("idUtilizador", $user["id"]);
                $stmt -> execute();
                if ($stmt -> rowCount() == 0) {
                    showMessage(true, "Não foi possivel alterar o utilizador (ID: ".$user["id"].")");
                    gotoListUsers();
                }
            }
        }
        showMessage(false, "Alterou com sucesso o utilizador (ID: ".$user["id"].")");
        gotoListUsers();
        
    } else {
        gotoListUsers();
    }

    function showErrorValue($code, $reason) {
        $_SESSION["badEdit"] = [
            "code" => $code,
            "reason" => $reason
        ];
    }

    function showMessage($isError, $msg) {
        $_SESSION["message"] = [
            "isError" => $isError,
            "msg" => $msg
        ];
    }
?>