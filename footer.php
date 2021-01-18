<footer id="footer">
    <div class="footer">
        <div class="footer-links">
            <span>
                Centro de inspeções
            </span>
            <br>
            <img src="/ProjetoPWBD/assets/img/icon.png" alt="" srcset="">
        </div>
        <div class="footer-links">
            <span>
                Ligações
            </span>
            <ul>
                <li class="footer-links-item">
                    <a href="/ProjetoPWBD/">
                        Página principal
                    </a>
                </li>
                <li class="footer-links-item">
                    <a href="/ProjetoPWBD/contact.php">
                        Contactos
                    </a>
                </li>
                <?php
                    if(checkIfAdmin()) {
                        echo "
                            <li class='footer-links-item'>
                                <a href='/ProjetoPWBD/admin/'>
                                    Painel de controlo
                                </a>
                            </li>
                        ";
                    }
                    if (checkIfLogged()) {
                        echo "
                            <li class='footer-links-item'>
                                <a href='/ProjetoPWBD/mydata.php'>
                                    Meus Dados
                                </a>
                            </li>
                            <li>
                                <a href='/ProjetoPWBD/logout.php'>
                                    Logout
                                </a>
                            </li>
                        ";
                    } else {
                        echo "
                            <li class='footer-links-item'>
                                <a href='/ProjetoPWBD/login.php'>
                                    Login
                                </a>
                            </li>
                            <li>
                                <a href='/ProjetoPWBD/register.php'>
                                    Registar
                                </a>
                            </li>
                        ";
                    }
                ?>
            </ul>
        </div>
        <div class="footer-links">
            <span>
                Créditos
            </span>
            <ul>
                <li class="footer-links-item">
                    Icons feitos por
                    <a href="https://www.flaticon.com/authors/freepik" target="_blank">
                        Freepik
                    </a>
                    de
                    <a href="https://www.flaticon.com/" target="_blank">
                        www.flaticon.com
                    </a>
                </li>
                <li class="footer-links-item">
                    Repositório:
                    <a href="https://github.com/Kaentos/ProjetoPWBD/" target="_blank">
                        Github
                    </a>
                </li>
                <li class="footer-links-item">
                    Desenvolvedores:
                    <a href="https://github.com/Thekings2468" target="_blank">
                        André Duarte
                    </a> & 
                    <a href="https://github.com/Kaentos" target="_blank">
                        Miguel Magueijo
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>