<?php
    session_start();
    unset($_SESSION["badLogin"]);
    if (isset($_POST["l_user"]) && isset($_POST["l_pwd"])) {
        include("basedados.h");
        include("rules.php");

        $user = $_POST["l_user"];
        $pwd = $_POST["l_pwd"];

        if (strlen($user) >= USER_MIN_LENGTH && strlen($pwd) >= PWD_MIN_LENGTH) {
            if (filter_var($user, FILTER_VALIDATE_EMAIL))
                define("SQL_COLUMN", "email");
            else
                define("SQL_COLUMN", "username");

            $query = "SELECT * FROM Utilizador WHERE ". SQL_COLUMN ."= :name;";
            $stmt =  $dbo -> prepare($query);
            $stmt -> bindParam(":name", $user);
            $stmt -> execute();
            if ($stmt -> rowCount() == 1) {
                $result = $stmt -> fetch();
                if ($result["isActive"] == FALSE) {
                    $_SESSION["badLogin"] = "Por favor aguarde que a sua conta seja validada.";
                } else if ($result["isDeleted"]) {
                    $_SESSION["badLogin"] = "Esta conta encontra-se eliminada.";
                } else {
                    if (password_verify($pwd, $result["password"])) {
                        $login_user = [
                            "id" => $result["id"],
                            "name" => $result["nome"],
                            "username" => $result["username"],
                            "type" => $result["idTipo"]
                        ];
                        if (isset($_POST["l_keepLogin"]) && $_POST["l_keepLogin"] == "keep") {
                            setcookie("login", json_encode($login_user), time() + 86400 * 7, "/"); // 86400 = 1 dia
                        } else {
                            $_SESSION["login"] = $login_user;
                        }
                        header("location: ../../index.php");
                        die();
                    }
                }
            } else if ($stmt -> rowCount() > 1) {
                echo "Bad login WARN ADMIN";
            }
        }
        if (!isset($_SESSION["badLogin"])) {
            $_SESSION["badLogin"] = "Dados incorretos";
        }
        mysqli_close($conn);
        header("location: ../../login.php");
        die();
    } else {
        $_SESSION["badLogin"] = "Dados incorretos";
        header("location: ../../login.php");
        die();
    }
?>