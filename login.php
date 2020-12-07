<?php
    function loginWithEmail($conn, $user, $pwd) {

    }
    function loginWithUsername($conn, $user, $pwd) {

    }

    if (isset($_POST["loginBtn"])) {
        include("./basedados.h");
        include("./rules.php");
        //echo "yes<br>";

        if(isset($_POST["user"]) && isset($_POST["pwd"])) {
            $user = $_POST["user"];
            $pwd = $_POST["pwd"];
            if(strlen($user) >= USER_MIN_LENGTH && strlen($pwd) >= PWD_MIN_LENGTH) {
                if(strpos($user, "@"))
                    loginWithEmail($conn, $user, $pwd);
                else
                    loginWithUsername($conn, $user, $pwd);
            } else {
                //echo "Data";
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
    <form action="" method="POST">
        <div class="input-group">
            <label for="user">Username/Email:</label>
            <input type="text" name="user" id="user">
        </div>
        <div class="input-group">
            <label for="pwd">Password:</label>
            <input type="password" name="pwd" id="pwd">
        </div>
        
        <input type="submit" value="Login" name="loginBtn" id="loginBtn">
    </form>
</body>
</html>