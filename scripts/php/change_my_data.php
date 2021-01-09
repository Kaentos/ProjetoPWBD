<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    checkIfNotLoggedWithGoto();

    if ( isset($_POST["md_cPwd"]) && isset($_POST["md_username"]) && isset($_POST["md_email"]) && isset($_POST["md_name"]) && isset($_POST["md_mobile"]) && isset($_POST["md_tel"]) ) {
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");

        $query = "
            SELECT *
            FROM utilizador
            WHERE id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $idUser = LOGIN_DATA["id"];
        $stmt -> bindParam("id", $idUser);
        $stmt -> execute();
        if ($stmt -> rowCount() == 1) {
            $oldUser = $stmt -> fetch();
        } else {
            header("location: /ProjetoPWBD/logout.php");
            die();
        }

        if (!password_verify($_POST["md_cPwd"], $oldUser["password"])) {
            showErrorValue(8, "Palavra-passe atual errada");
            gotoMyData();
        }

        $newUser = array(
            "id" => $oldUser["id"],
            "username" => $_POST["md_username"],
            "email" => $_POST["md_email"],
            "nome" => $_POST["md_name"],
            "telemovel" => $_POST["md_mobile"],
            "telefone" => strlen($_POST["md_tel"]) == 0 ?  null : $_POST["md_tel"],
            "dataEdicao" => date("Y/m/d H:i:s")
        );

        $editColumns = "SET nome = :nome, username = :username, email = :email, telemovel = :telemovel, telefone = :telefone, dataEdicao = :dataEdicao";

        if ( isset($_POST["md_pwd"]) && isset($_POST["md_pwd2"]) ) {
            if ( preg_match(REGEX_PWD, $_POST["md_pwd"]) && strcmp($_POST["md_pwd"], $_POST["md_pwd2"] ) == 0 ) {
                $editColumns = $editColumns . ", password = :password";
                $newUser["password"] = password_hash($_POST["md_pwd"], PASSWORD_BCRYPT, ["cost" => 12]);
            } 
        }

        if ( !preg_match(REGEX_USERNAME, $newUser["username"]) ) {
            showErrorValue(1, "Username inválido");
            gotoMyData();
        } else {
            $query = "
                SELECT id 
                FROM utilizador
                WHERE username = :username AND id != :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindParam("username", $newUser["username"]);
            $stmt -> bindParam("id", $newUser["id"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                showErrorValue(1, "Username (" . $newUser["username"] . ") já existe");
                gotoMyData();
            }
        }

        if ( !preg_match(REGEX_EMAIL, $newUser["email"]) ) {
            showErrorValue(2, "Email inválido");
            gotoMyData();
        } else {
            $query = "
                SELECT id 
                FROM utilizador
                WHERE email = :email AND id != :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindParam("email", $newUser["email"]);
            $stmt -> bindParam("id", $newUser["id"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                showErrorValue(2, "Email (" . $newUser["email"] . ") já existe");
                gotoMyData();
            }
        }

        if ( !preg_match(REGEX_NAME, $newUser["nome"]) ) {
            showErrorValue(5, "Nome de utilizador inválido");
            gotoMyData();
        }

        if ( !preg_match(REGEX_CONTACTNUMBER, $newUser["telemovel"]) ) {
            showErrorValue(6, "Nº de telemóvel inválido");
            gotoMyData();
        }

        if ($newUser["telefone"] != null && !preg_match(REGEX_CONTACTNUMBER, $newUser["telefone"]) ) {
            showErrorValue(7, "Número de telefone inválido");
            gotoMyData();
        }

        $query = "
            UPDATE utilizador
            ". $editColumns ."
            WHERE id = :id
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($newUser);

        if ($stmt -> rowCount() == 1) {
            showMessage(false, "Alterou os seus dados");
            gotoMyData();
        } else {
            showMessage(true, "Não foi possivel alterar os seus dados");
            gotoMyData();
        }
    } else {
        gotoMyData();
    }

    function showErrorValue($code, $reason) {
        $_SESSION["badMyData"] = [
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