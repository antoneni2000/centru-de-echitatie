<?php
include_once 'DBController.php';

$error = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeUtilizator = $_POST['NumeUtilizator'];
    $parola = password_hash($_POST['Parola'], PASSWORD_DEFAULT);
    $nivelCompetenta = $_POST['NivelCompetenta'];
    $nume = $_POST['Nume'];
    $email = $_POST['Email'];
    $nrTelefon = $_POST['NrTelefon'];
    $dataNasterii = $_POST['DataNasterii'];
    $dataCrearii = date('Y-m-d H:i:s');

    try {
        $dbController = new DBController();
        $db = $dbController->getConnection();

        $db->beginTransaction();

        $query = "INSERT INTO users (NumeUtilizator, ParolaHash, NivelCompetenta, DataCrearii, Nume, Email, NrTelefon, DataNasterii) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            $numeUtilizator, 
            $parola, 
            $nivelCompetenta, 
            $dataCrearii, 
            $nume, 
            $email, 
            $nrTelefon, 
            $dataNasterii
        ]);

        $db->commit();

        $message = "Înregistrarea a fost realizată cu succes!";
    } catch (Exception $e) {
        $db->rollBack();
        $error = "Eroare la inserarea datelor: " . $e->getMessage();
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
    <title id = "page-title-6">Inregistreaza-te!</title>
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
	
		<div class="registration-form">
        <h2 id="signup-title">Inregistrare</h2>
        <?php if ($error): ?>
            <div class="alert" id="error-message"><?= $error; ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
        <div class="alert" id="success-message"><?= $message; ?></div>
        <?php endif; ?>

        <form action="sign_up.php" method="POST" id="signup-form">
        <div class="form-group" id="username-group">
            <label for="NumeUtilizator" class="form-label" id="username-label">Nume Utilizator</label>
            <input type="text" id="NumeUtilizator" name="NumeUtilizator" class="form-input" required>
        </div>

        <div class="form-group" id="password-group">
            <label for="Parola" class="form-label" id="password-label">Parola</label>
            <input type="password" id="Parola" name="Parola" class="form-input" required>
        </div>

        <div class="form-group" id="skill-level-group">
            <label for="NivelCompetenta" class="form-label" id="skill-level-label">Nivel Competentă</label>
            <select id="NivelCompetenta" name="NivelCompetenta" class="form-input" required>
                <option value="Începător" id="beginner-option">Începător</option>
                <option value="Intermediar" id="intermediate-option">Intermediar</option>
                <option value="Avansat" id="advanced-option">Avansat</option>
            </select>
        </div>

        <div class="form-group" id="name-group">
            <label for="Nume" class="form-label" id="name-label">Nume</label>
            <input type="text" id="Nume" name="Nume" class="form-input" required>
        </div>

        <div class="form-group" id="email-group">
            <label for="Email" class="form-label" id="email-label">Email



  <script src="js/toggle.js"></script>
  <script src="https://kit.fontawesome.com/fc632b9fc3.js" crossorigin="anonymous"></script>
  <script src="js/localization.js" defer></script>
</body>       
</html>
</body>
</html>

