<?php
    session_start();
    unset($_SESSION["badLogin"]);
    if(isset($_POST["l_user"]) && isset($_POST["l_pwd"])) {
        include("basedados.h");
        include("rules.php");

        $user = $_POST["l_user"];
        $pwd = $_POST["l_pwd"];

        if(strlen($user) >= USER_MIN_LENGTH && strlen($pwd) >= PWD_MIN_LENGTH) {
            if(filter_var($user, FILTER_VALIDATE_EMAIL))
                define("SQL_COLUMN", "email");
            else
                define("SQL_COLUMN", "username");

            $query = "SELECT * FROM Utilizador WHERE ". SQL_COLUMN ."='$user';";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row["isActive"] == FALSE) {
                    $_SESSION["badLogin"] = "Por favor aguarde que a sua conta seja validada.";
                } else if ($row["isDeleted"]) {
                    $_SESSION["badLogin"] = "Esta conta encontra-se eliminada.";
                } else {
                    if (password_verify($pwd, $row["password"])) {
                        $login_user = [
                            "userID" => $row["id"],
                            "userNome" => $row["nome"],
                            "username" => $row["username"],
                            "userType" => $row["idTipo"]
                        ];
                        if (isset($_POST["l_keepLogin"]) && $_POST["l_keepLogin"] == "keep") {
                            setcookie("login", json_encode($login_user), time() + 86400 * 7, "/"); // 86400 = 1 dia
                        } else {
                            $_SESSION["login"] = $login_user;
                        }
                        mysqli_close($conn);
                        header("location: ../../index.php");
                        die();
                    }
                }
            } else if ($result && mysqli_num_rows($result) > 1) {
                echo "Bad login WARN ADMIN";
            }
        }
        if (!isset($_SESSION["badLogin"])) {
            $_SESSION["badLogin"] = "Dados incorretos.";
        }
        mysqli_close($conn);
        header("location: ../../login.php");
        die();
    } else {
        $_SESSION["badLogin"] = "Dados incorretos.";
        header("location: ../../login.php");
        die();
    }
?>