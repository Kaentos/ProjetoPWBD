<?php
    include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/major_functions.php");
    unset($_SESSION["badRegister"]);
    if(isset($_POST["r_name"]) && isset($_POST["r_username"]) && isset($_POST["r_email"]) && isset($_POST["r_pwd"]) && isset($_POST["r_pwd2"]) && isset($_POST["r_mobile"])) {
        include($_SERVER["DOCUMENT_ROOT"]."/ProjetoPWBD/scripts/php/basedados.h");

        $user = [
            "name" => trim($_POST["r_name"]),
            "username" => trim($_POST["r_username"]),
            "email" => trim($_POST["r_email"]),
            "pwd" => $_POST["r_pwd"],
            "pwd2" => $_POST["r_pwd2"],
            "mobile" => trim($_POST["r_mobile"]),
            "tel" => isset($_POST["r_tel"]) && strlen(trim($_POST["r_tel"])) == 9 ? trim($_POST["r_tel"]) : null,
        ];
        if (!preg_match(REGEX_USERNAME, $user["username"])) {
            gotoRegisterWithError("Nome de utilizador inválido", $user, 1);
        } else {
            $query = "SELECT id FROM Utilizador WHERE username = :username";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindParam(":username", $user["username"]);
            $stmt -> execute();
            if ($stmt -> rowCount() == 1) {
                gotoRegisterWithError("Nome de utilizador já em uso", $user, 1);
            }
        }
        if (!preg_match(REGEX_EMAIL, $user["email"])) {
            gotoRegisterWithError("Email inválido",$user, 2);
        } else {
            $query = "SELECT id FROM Utilizador WHERE email = :email";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindParam(":email", $user["email"]);
            $stmt -> execute();
            if ($stmt -> rowCount() == 1) {
                gotoRegisterWithError("Email já em uso", $user, 2);
            }
        }
        if (!preg_match(REGEX_PWD, $user["pwd"])) {
            gotoRegisterWithError("Palavra-passe inválida", $user , 3);
        }
        if ($user["pwd"] !== $user["pwd2"]) {
            gotoRegisterWithError("Palavras-passes não correspondem", $user, 3);
        }
        if (!preg_match(REGEX_NAME, $user["name"])) {
            gotoRegisterWithError("Nome inválido",$user, 5);
        }
        if (!preg_match(REGEX_CONTACTNUMBER, $user["mobile"])) {
            gotoRegisterWithError("Número de telemóvel inválido", $user, 6);
        }
        if ($user["tel"] !== null && !preg_match(REGEX_CONTACTNUMBER, $user["tel"])) {
            gotoRegisterWithError("Número de telefone inválido", $user, 7);
        }
        $user["pwd"] = password_hash($user["pwd"], PASSWORD_BCRYPT, ["cost" => 12]);
        $query = "
            INSERT INTO Utilizador (nome, username, email, password, telemovel, telefone, idTipo) 
            VALUE (:name, :username, :email, :pwd, :mobile, :tel, :idTipo);
        ";
        $stmt =  $dbo -> prepare($query);
        $stmt -> bindValue(":name", $user["name"]);
        $stmt -> bindValue(":username", $user["username"]);
        $stmt -> bindValue(":email", $user["email"]);
        $stmt -> bindValue(":pwd", $user["pwd"]);
        $stmt -> bindValue(":mobile", $user["mobile"]);
        $stmt -> bindValue(":tel", $user["tel"]);
        if (isset($_POST["r_userType"])) {
            $checkQuery = "
                SELECT *
                FROM TipoUtilizador
                WHERE id = ".$_POST["r_userType"]."
            ";
            $checkStmt = $dbo -> prepare($checkQuery);
            $checkStmt -> execute();
            if ($checkStmt -> rowCount() == 1) {
                $stmt -> bindValue("idTipo", $_POST["r_userType"]);
            } else {
                $error = "Tipo de utilizador inválido";
                $_SESSION["badRegister"] = ["error" => $error, "user" => $user, "code" => 8];
                gotoAddUser();
            }
        } else {
            $stmt -> bindValue("idTipo", USER_TYPE_CLIENT);
        }
        if ($stmt -> execute()) {
            if (isset($_POST["r_userType"])) {
                gotoListUsers();
            } else {
                gotoIndex();
            }
        } else {
            gotoRegisterWithError("Contact admin.", $user, 0);
        }

    } else {
        gotoRegisterWithError("error", $user, 0);
    }

    function cleanData($input) {
        $input = trim($input);
    }

    function gotoRegisterWithError($error, $user, $code) {
        unset($user["pwd"]);
        unset($user["pwd2"]);
        $_SESSION["badRegister"] = ["error" => $error, "user" => $user, "code" => $code];
        gotoRegister();
    }
?>