<nav class="navbar" id="navbar">
    <div>
        <div class="navbar-title">
            Centro de Inspeções
        </div>
        <div class="navbar-links">
            <a href="/">Main Page</a>
            <a href="/">Dados</a>
            <?php
                if (isset($_COOKIE["login"])) {
                    $user = json_decode($_COOKIE["login"]);
                    if ($user["type"] !== 3) {
                        
                    }
                }
                if ($_SESSION["login"]["type"] === 3)
            ?>
        </div>
    </div>
    <div>
        <div class="navbar-links">
            <a class="navbar-login navbar-LR" href="login.php">Login</a>
            <a class="navbar-register navbar-LR" href="register.php">Registar</a>
        </div>
    </div>
</nav>