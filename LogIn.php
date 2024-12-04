<?php
session_start();

include_once "DBController.php";

$db = new DBController();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM users WHERE NumeUtilizator = :username";
        $params = [':username' => $username];
        $user = $db->getDBResult($query, $params);

        if ($user && password_verify($password, $user[0]['ParolaHash'])) {
            $_SESSION['username'] = $user[0]['NumeUtilizator'];
            $_SESSION['UserID'] = $user[0]['UserID'];
            header("Location: hpli.php");
            exit();
        } else {
            $error = "Username sau parola gresita.";
        }
    } catch (Exception $e) {
        $error = "Eroare la verificarea utilizatorului: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="centru de echitatie pentru iubitori de cai in cluj">
    <meta name="keyword" content="calarit, echitatie, cai, cal, cluj">
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="css/clrimpreuna.css">
    <title id ="page-title-5">Intra in cont</title>
</head>
<body>

    <header>
    <nav class="navbar">
            <div class="branding">
                <a href="HomePage.html"><img id="logo" src="images/logo2.png" alt="logo"></a>
            </div>
            <div class="navbar-menu">
                <ul>
                    <li><a href="HomePage.html" id="nav-home">Acasă</a></li>
                    <li><a href="educational.html" id="nav-did-you-know">Știai că?</a></li>
                    <li><a href="galerie.html" id="nav-gallery">Galerie</a></li>
                    <li><a href="Programari.php" id="nav-schedule">Programează-te</a></li>
                    <li><a href="contact.html" id="nav-contact">Contactează-ne!</a></li>
                    <li><a href="LogIn.php" id="nav-login">Intră în cont</a></li>
                    <li><a href="sign_up.php" id="nav-signup">Fă-ți un cont</a></li>
                </ul>
            </div>
            <select id="language-selector">
                <option value="ro">Română</option>
                <option value="en">English</option>
                <option value="fr">Français</option>
            </select>
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
        </nav>
  </header>
  <div class="login">
        
        <?php if ($error): ?>
            <div class="alert"><?= $error; ?></div>
        <?php endif; ?>

        <form action="LogIn.php" method="POST">
    <div class="form-group">
        <label for="username" id="login-username-label">Nume Utilizator</label>
        <input type="text" id="username" name="username" class="form-input" required>
    </div>

    <div class="form-group">
        <label for="password" id="login-password-label">Parola</label>
        <input type="password" id="password" name="password" class="form-input" required>
    </div>

    <button id="login-button">Log In</button>
</form>
    </div>
    <footer>
    <div class="copyright">
            <h3 id="footer-title">Centru de călărie | Călărim împreună</h3>
            <p id="footer-copyright">Copyright © All Rights Reserved</p>
        </div>
        <div>
            <ul class="social-networks">
                <li><a href="https://facebook.com" target="_blank" rel="noopener" id="social-facebook"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="https://twitter.com" target="_blank" rel="noopener" id="social-twitter"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="https://www.youtube.com" target="_blank" rel="noopener" id="social-youtube"><i class="fa-brands fa-youtube"></i></a></li>
                <li><a href="https://www.instagram.com/" target="_blank" rel="noopener" id="social-instagram"><i class="fa-brands fa-instagram"></i></a></li>
            </ul>
        </div>

</footer>

  <script src="js/toggle.js"></script>
  <script src="https://kit.fontawesome.com/fc632b9fc3.js" crossorigin="anonymous"></script>
  <script src="js/localization.js" defer></script>
</body>
</html>
