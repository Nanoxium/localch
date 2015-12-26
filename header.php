<header>
    <h1>Projet M152 - Local.ch</h1>
    <!-- menu -->
    <nav>
        <ul>
            <li><a class="link" href="index.php">Accueil</a></li>
            <?= (!isset($_SESSION['username'])) ? '<li><a class="link" href="login.php">Se connecter</a></li>' : ""; ?>
            <?= (!isset($_SESSION['username'])) ? '<li><a class="link" href="signup.php">S\'enregistrer</a></li>' : ""; ?>
            <?= (isset($_SESSION['username'])) ? '<li><a class="link" href = "index.php?logout=true">Déconnextion</a>' : "" ?>
        </ul>
    </nav>
</header>

