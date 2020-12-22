<?php
    session_start();
    unset($_SESSION["badRegister"]);
    if(isset($_POST["r_name"]) && isset($_POST["r_username"]) && isset($_POST["r_email"])
     && isset($_POST["r_pwd"]) && isset($_POST["r_pwd2"]) && isset($_POST["r_mobile"])) {
        include("basedados.h");
        include("rules.php");

        $user = [
            "name" => trim($_POST["r_name"]),
            "username" => trim($_POST["r_username"]),
            "email" => trim($_POST["r_email"]),
            "pwd" => $_POST["r_pwd"],
            "pwd2" => $_POST["r_pwd2"],
            "mobile" => trim($_POST["r_mobile"]),
            "tel" => isset($_POST["r_tel"]) && strlen(trim($_POST)) == 9 ? trim($_POST["r_tel"]) : null,
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
        $query = "INSERT INTO Utilizador (nome, username, email, password, telemovel, telefone, idTipo)
            VALUE (:name, :username, :email, :pwd, :mobile, :tel, 1);";
        $stmt =  $dbo -> prepare($query);
        $stmt -> bindParam(":name", $user["name"]);
        $stmt -> bindParam(":username", $user["username"]);
        $stmt -> bindParam(":email", $user["email"]);
        $stmt -> bindParam(":pwd", $user["pwd"]);
        $stmt -> bindParam(":mobile", $user["mobile"]);
        $stmt -> bindParam(":tel", $user["tel"]);
        
        if ($stmt -> execute()) {
            gotoIndex();
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
    function gotoRegister() {
        header("location: ../../register.php");
        die();
    }

    function gotoIndex() {
        header("location: ../../index.php");
        die();
    }
?>