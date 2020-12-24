<nav class="navbar" id="navbar">
    <div>
        <div class="navbar-title">
            <a href="/ProjetoPWBD/">Centro de Inspeções</a>
        </div>
        <div class="navbar-links">
            <a href="/ProjetoPWBD/">Página principal</a>
            <?php
                if (checkIfAdmin()) {
                    echo "
                        <a href='/ProjetoPWBD/admin'>Painel de controlo</a>
                    ";
                } else if (checkIfInspector()) {
                    echo "
                        <a href='/ProjetoPWBD/admin'>Nao sei</a>
                    ";
                } else if (checkIfClient()) {
                    echo "
                        <a href='/ProjetoPWBD/admin'>Meus dados</a>
                        <a href='/ProjetoPWBD/admin'>Marcações</a>
                        <a href='/ProjetoPWBD/admin'>Minhas Marcações</a>
                        <a href='/ProjetoPWBD/admin'>Meus veículos</a>
                    ";
                }
            ?>
        </div>
    </div>
    <div>
        <?php
            if (checkIfLogged()) {
                echo "
                    <div class='navbar-links'>
                        <a class='navbar-myData navbar-LR' href='/'>Meus dados</a>
                        <a class='navbar-logout navbar-LR' href='/ProjetoPWBD/logout.php'>Logout</a>
                    </div>
                ";
            } else {
                echo "
                    <div class='navbar-links'>
                        <a class='navbar-login navbar-LR' href='login.php'>Login</a>
                        <a class='navbar-register navbar-LR' href='register.php'>Registar</a>
                    </div>
                ";
            }
        ?>
        
    </div>
</nav>