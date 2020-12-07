<?php
    function loginWithEmail($conn, $user, $pwd) {
        
    }
    function loginWithUsername($conn, $user, $pwd) {

    }

    if (isset($_POST["loginBtn"])) {
        include("./basedados.h");
        include("./rules.php");

        if(isset($_POST["l_user"]) && isset($_POST["l_pwd"])) {
            $user = $_POST["l_user"];
            $pwd = $_POST["l_pwd"];
            if(strlen($user) >= USER_MIN_LENGTH && strlen($pwd) >= PWD_MIN_LENGTH) {
                if(strpos($user, "@"))
                    loginWithEmail($conn, $user, $pwd);
                else
                    loginWithUsername($conn, $user, $pwd);
            } else {
                incorrectData($user);
            }
        } else {
            incorrectData("");
        }

        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login_register.css">
    <?php 
        function incorrectData($user) {
            echo "<script src='./Assets/JS/login.js'></script>";
            echo "<script>
                    window.onload = function(){incorrectData('$user');}
                </script>";
        }
    ?>
    <title>Login</title>
</head>
<body>
    <nav id="navbar"></nav>
    <div class="lr-zone">
        <div class="lr-panel">
            <h1>
                Login
            </h1>
            <div class="lr-form">
                <form action="" method="POST">
                    <div class="lr-inputGroup">
                        <label for="l_user">Username/Email:</label>
                        <input type="text" name="l_user" id="l_user">
                    </div>
                    <div class="lr-inputGroup">
                        <label for="l_pwd">Password:</label>
                        <input type="password" name="l_pwd" id="l_pwd">
                        <a href="">Esqueci-me da password.</a>
                    </div>
                    
                    <div class="lr-inputBtn">
                        <input type="submit" value="Login" name="loginBtn" id="loginBtn">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    
    <footer id="footer"></footer>
</body>
</html>