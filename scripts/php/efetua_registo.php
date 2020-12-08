<?php
    session_start();
    unset($_SESSION["badRegister"]);
    if(isset($_POST["r_name"]) && isset($_POST["r_username"]) && isset($_POST["r_email"])
     && isset($_POST["r_pwd"]) && isset($_POST["r_pwd2"]) && isset($_POST["r_address"])
      && isset($_POST["r_cc"]) && isset($_POST["r_date"]) && isset($_POST["r_mobile"])) {
        include("basedados.h");
        include("rules.php");

        $user = [
            "name" => trim($_POST["r_name"]),
            "username" => trim($_POST["r_username"]),
            "email" => trim($_POST["r_email"]),
            "pwd" => $_POST["r_pwd"],
            "pwd2" => $_POST["r_pwd2"],
            "address" => trim($_POST["r_address"]),
            "cc" => trim($_POST["r_cc"]),
            "date" => trim($_POST["r_date"]),
            "mobile" => trim($_POST["r_mobile"]),
            "tel" => isset($_POST["r_tel"]) && strlen(trim($_POST)) == 9 ? trim($_POST["r_tel"]) : "null",
        ];
        
        if (FINAL_USER["pwd"] != FINAL_USER["pwd2"]) {
            $badRegister = ["As palavras passes devem ser iguais", $user];
            header("../../registo.php");
            die();
        }
        $user["pwd"] = password_hash($user["pwd"], PASSWORD_BCRYPT, ["cost" => 12]);
        define("FINAL_USER", $user);
        $query = "INSERT INTO Utilizador (nome, username, email, password, morada, cc, dataNasc, telemovel, telefone, idTipo)
            VALUE ('".FINAL_USER["name"]."',
            '".FINAL_USER["name"]."',
            '".FINAL_USER["email"]."',
            '".FINAL_USER["pwd"]."',
            '".FINAL_USER["address"]."',
            ".FINAL_USER["cc"].",
            '".FINAL_USER["date"]."',
            ".FINAL_USER["mobile"].",
            ".FINAL_USER["tel"].", 3)";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "yes";
        } else {
            echo "fuck " . $query . mysqli_error($result);
        }
        

    } else {
        $_SESSION["badRegister"] = "Dados incorretos.";
        header("location: ../../registo.php");
        die();
    }

    function cleanData($input) {
        $input = trim($input);
    }
?>