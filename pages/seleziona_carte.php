<?php
require_once("inizializzazione_sessione.php");
require_once("./connessione.php");

if(!$_SESSION["isLogged"]){
    header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
}

if(!isset($_SESSION['sceltaN'])){
    header("Location: http://localhost/progetto_fabiani_faberi/pages/scegli_mazzo.php");
}


$userId = $_SESSION["id"];

$result = $connection->prepare("SELECT Carte.Id, Carte.Nome, Carte.Immagine, a.Danno 
    FROM Carte_Possedute cp
    JOIN Carte ON cp.Id_carta = Carte.Id
    JOIN Attacchi a ON Carte.Attacco = a.Id
    WHERE cp.Id_utente = ?");
$result->execute([$userId]);
$carte = $result->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['scelte'])) {
    $scelte = $_POST['scelte'];
    if (count($scelte) != 5) {
        $errore = "Seleziona esattamente 5 carte!";
    } else {
        $_SESSION['scelte'] = $scelte;
        header("Location: http://localhost/progetto_fabiani_faberi/pages/setUp_lotte.php");
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Seleziona le tue carte</title>
    <link rel="stylesheet" href="../styles/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">GCC pokemon pocket</a>
        <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
            <img src="../images/layout/offcanvas_logo.png" alt="Menu Icon" style="width: 24px; height: 24px;">
        </button>
    </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <?php if (!$_SESSION["isLogged"]) : ?>
                <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="./sign_up.php">Sign Up</a></li>
            <?php else : ?>
                <li class="nav-item"><a class="nav-link" href="./profilo.php">Profilo</a></li>
                <li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>
                <br>
                <?php if (!$_SESSION["isAdmin"]) : ?>
                    <li class="nav-item"><a class="nav-link" href="./pacchetti.php">Pacchetti</a></li>
                    <li class="nav-item"><a class="nav-link" href="./carte.php">Carte</a></li>
                    <li class="nav-item"><a class="nav-link" href="./scegli_mazzo.php">Lotte</a></li>
                    <li class="nav-item"><a class="nav-link" href="./storico_lotte.php">Storico lotte</a></li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="form_delete_user.php">Elimina un utente</a></li>
                    <li class="nav-item"><a class="nav-link" href="./form_unban_email.php">Ripristina una email</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<h1>Ciao <?= $_SESSION["username"] ?>, scegli 5 carte per la lotta</h1>

<form method="post">
    <?php foreach ($carte as $carta) : ?>
        <label class="cards">
            <img src="<?= $carta['Immagine'] ?>" height="100"><br>
            <input type="checkbox" name="scelte[]" value="<?= $carta['Id'] ?>">
            <?= $carta['Nome'] ?> (<?= $carta['Danno'] ?> danni)
        </label>
    <?php endforeach; ?>
    <br><br>
    <button type="submit">Avvia lotta!</button>
</form>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
