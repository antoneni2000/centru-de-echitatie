<?php
session_start();

// Includem clasa DBController
include_once "DBController.php"; 

// Creăm o instanță a clasei DBController
$db = new DBController();


$message = '';
$horses = [];

try {
    // Obține lista de cai din baza de date
    $query = "SELECT HorseID, Nume FROM horses";
    $horses = $db->getDBResult($query);
} catch (Exception $e) {
    $message = "Eroare la încărcarea listei de cai: " . $e->getMessage();
}

// Verificăm dacă formularul a fost trimis	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variabilele PHP pentru datele primite din formular
    $data_programare = $_POST['data_programare'] ?? '';
    $ora = $_POST['ora'] ?? '';
    $mesaj = trim($_POST['mesaj'] ?? '');
    $HorseID = $_POST['HorseID'] ?? '';
    $UserID = $_SESSION['UserID'];

    // Validare date
    if (empty($data_programare) || empty($ora) || empty($HorseID) || empty($UserID)) {
        $message = "Toate câmpurile obligatorii trebuie completate.";
    } else {
        // Validare intervale orare
        $ziua_saptamanii = date('N', strtotime($data_programare)); // 1 = Luni, 7 = Duminică
        $ora_selectata = (int)substr($ora, 0, 2); // primele 2 caractere din 'HH:MM'
        
        if (($ziua_saptamanii >= 1 && $ziua_saptamanii <= 5 && ($ora_selectata < 15 || $ora_selectata >= 19)) ||
            ($ziua_saptamanii == 6 || $ziua_saptamanii == 7) && ($ora_selectata < 9 || $ora_selectata >= 12)) {
            $message = "Ora selectată nu este validă pentru această zi.";
        } else {
            try {
                // Inserare programare în baza de date
                $query = "INSERT INTO programari (data_programare, ora, mesaj, HorseID, UserID) 
                          VALUES (:data_programare, :ora, :mesaj, :HorseID, :UserID)";
                $params = [
                    ':data_programare' => $data_programare,
                    ':ora' => $ora,
                    ':mesaj' => $mesaj,
                    ':HorseID' => $HorseID,
                    ':UserID' => $UserID
                ];

                // Executăm inserarea în baza de date
                $db->updateDB($query, $params); 

                // Verificăm dacă trigger-ul a fost activat
                // De obicei trigger-ele nu dau feedback direct, dar dacă nu a apărut o eroare, presupunem că a fost activat
                $message = "Programarea a fost salvată cu succes!";
            } catch (Exception $e) {
                $message = "Eroare la conexiunea cu baza de date: " . $e->getMessage();
            }
        }
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
    <link rel = "stylesheet" href = "css/clrimpreuna.css">
    <title>Programeaza-te</title>
   
</head>
<body>
    <header>
        <h1>Programare pentru călărie</h1>
    
    <nav class="navbar">

        <div class="branding">   
        <a href="HomePage.html"><img id="logo" src="images/logo2.png" alt="logo"/></a> 
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

<section>
    <div class = "container-booking">
        <div class = "booking">
            <div class = "descrip">
            <h2 id = "booking-title"><strong> Programeaza-te</strong></h2>

            <p id ="booking-description"> Va rugam sa alegeti activitatea si abilitatile de calarit, iar apoi data si ora la care doriti sa veniti.
                Nu va supraestimati abilitatile de calarie deoarece este periculos atat pentru dumneavoastra, cat si pentru ceilalti.
                Daca nu sunteti onesti, nu o sa va fie permis sa calariti!
            </p>

        <div class = "quote">
            <p id ="instructors-quote"> Instructorii nostri sunt calificati de FER si scopul nostru este sa va ajutam sa va placa si sa intelegeti caii.
                Toti caii nostri sunt folositi pentru dresaj, sarituri peste obstacole si cross-country, lucrand la diverse niveluri pentru a se potrivi
                cu abilitatea calaretului si au temperamentul foarte bun."          
            </p>
        </div>
        <ul>
            <li id ="service-1"> Servicii utile </li>
            <li id ="service-2">Spatiu exterior si interior </li>
            <li id = "service-3"> Experienta </li>
        </ul>
    </div>

    <div class = "form">
        <form action = "programari.php" method ="post">
        <div class = "inpbox full">
        <div class="form-group">
                <label class="form-label" for="nume" id="label-nume">Nume complet:</label>
                <input class="form-input" type="text" id="nume" name="nume" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="data_programare" id = "label-data-programare">Data programării:</label>
                <input class="form-input" type="date" id="data_programare" name="data_programare" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="ora" id="label-ora">Ora:</label>
                <input class="form-input" type="time" id="ora" name="ora" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="mesaj" id = "label-mesaj">Mesaj (opțional):</label>
                <textarea class="form-input" id="mesaj" name="mesaj" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="HorseID" id="label-horse">Selectează calul:</label>
                <select name="HorseID" class="form-input" required>
                    <?php
                    foreach ($horses as $horse) {
                        echo "<option value='" . $horse['HorseID'] . "'>" . $horse['Nume'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button class = "sub"  type="submit" id="btn-booking"><strong>Programează-te</strong></button>
            <button class = "reset" type ="reset" id="btn-reset">Reset</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

    

</form>
</div>
</div>
</div>
</section>
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

