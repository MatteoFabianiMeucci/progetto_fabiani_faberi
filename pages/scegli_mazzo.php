<?php
require_once("inizializzazione_sessione.php");
require_once("./connessione.php");

if(!$_SESSION["isLogged"]){
    header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    }
if($_SESSION["isAdmin"]){
    header("Location: http://localhost/progetto_fabiani_faberi/pages/?err=admin");
}

$result = $connection->prepare("
    SELECT l.Id, l.exp, l.premio, cl.Id_lotta, c.Id AS IdCarta, c.Nome, c.Immagine, c.PS, c.Tipo, c.Debolezza, c.Attacco, a.Danno, a.Nome as nomeAttacco
    FROM Carte_Lotte cl
    JOIN Lotte l ON cl.Id_lotta = l.Id
    JOIN Carte c ON c.Id = cl.Id_Carta
    JOIN Attacchi a ON c.Attacco = a.Id;
");
$result->execute();
$righe = $result->fetchAll(PDO::FETCH_ASSOC);

// Raggruppamento delle carte per Id_lotta
$lotte = [];
foreach ($righe as $riga) {
    $lotte[$riga['Id_lotta']][] = $riga;
}

if (isset($_POST['scelta_lotta'])) {
    $_SESSION['sceltaN'] = $_POST['scelta_lotta'];
    $idLotta = $_POST['scelta_lotta'];

    // Recupero solo delle carte della lotta scelta
    $result = $connection->prepare("
        SELECT c.Id, c.Nome, c.Immagine, c.PS, c.Tipo, c.Debolezza, c.Attacco, a.Danno, a.Nome as nomeAttacco
        FROM Carte_Lotte cl
        JOIN Carte c ON c.Id = cl.Id_Carta
        JOIN Attacchi a ON c.Attacco = a.Id
        WHERE cl.Id_lotta = ?
    ");
    $result->execute([$idLotta]);
    $_SESSION['mazzoNemico'] = $result->fetchAll(PDO::FETCH_ASSOC);

    header("Location: http://localhost/progetto_fabiani_faberi/pages/seleziona_carte.php");
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Seleziona la lotta</title>
    <link rel="stylesheet" href="../styles/style.css">
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
                <?php if(!$_SESSION["isLogged"]):?>
                    <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="./sign_up.php">Sign Up</a></li>
                <?php else:?>
                    <li class="nav-item"><a class="nav-link" href="./profilo.php">Profilo</a></li>
                    <li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>
                    <br>
                    <?php if(!$_SESSION["isAdmin"]):?>
                        <li class="nav-item"><a class="nav-link" href="./pacchetti.php">Pacchetti</a></li>
                        <li class="nav-item"><a class="nav-link" href="./carte.php">Carte</a></li>
                        <li class="nav-item"><a class="nav-link" href="./scegli_mazzo.php">Lotte</a></li>
                        <li class="nav-item"><a class="nav-link" href="./storico_lotte.php">Storico lotte</a></li>
                    <?php else:?>
                        <li class="nav-item"><a class="nav-link" href="form_delete_user.php">Elimina un utente</a></li>
                        <li class="nav-item"><a class="nav-link" href="./form_unban_email.php">Ripristina una email</a></li>
                    <?php endif;?>
                    
                <?php endif;?>
            </ul>
        </div>
    </div>

    <div class="container mt-4">
    <h1 class="text-center mb-4">Ciao <?= htmlspecialchars($_SESSION["username"]) ?>, scegli una lotta</h1>
    <form method="post">
        <?php foreach ($lotte as $idLotta => $carte): ?>
            <div class="lotta-group sezione">
                <label class="d-flex align-items-center">
                    <input type="radio" name="scelta_lotta" value="<?= $idLotta ?>" required class="me-3">
                    <strong>Lotta #<?= $idLotta ?></strong> 
                    <span class="ms-2">(Premio: <?= $carte[0]['premio'] ?>, Exp: <?= $carte[0]['exp'] ?>)</span>
                </label>
                <div class="cards d-flex flex-wrap justify-content-center">
                    <?php foreach ($carte as $carta): ?>
                        <div class="card-container">
                            <img class="cards" src="<?= htmlspecialchars($carta['Immagine']) ?>" alt="<?= htmlspecialchars($carta['Nome']) ?>" height="100" />
                            <p class="mt-2"><?= htmlspecialchars($carta['Nome']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="text-center mt-4">
            <button class="btn btn-primary px-4 py-2" type="submit">Avvia lotta!</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>