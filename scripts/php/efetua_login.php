<?php
    session_start();

    if(isset($_POST["l_user"]) && isset($_POST["l_pwd"])) {
        include("basedados.h");
        include("rules.php");

        $user = $_POST["l_user"];
        $pwd = $_POST["l_pwd"];

        if(strlen($user) >= USER_MIN_LENGTH && strlen($pwd) >= PWD_MIN_LENGTH) {
            if(strpos($user, "@"))
                define("SQL_USER_COLUMN", "email");
            else
                define("SQL_USER_COLUMN", "username");

            $query = "SELECT * FROM Utilizador WHERE ". SQL_USER_COLUMN ."='$user';";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row["isActive"] == FALSE) {
                    echo "Um administrador precisa de validar a sua conta! Por favor aguarde.";
                } else if ($row["isDeleted"]) {
                    echo "Esta conta já não existe no sistema.";
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
        mysqli_close($conn);
        header("location: ../../login.php");
        die();
    } else {
        header("location: ../../login.php");
        die();
    }
?>