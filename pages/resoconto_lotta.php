<?php
require_once("inizializzazione_sessione.php");
require_once("./connessione.php");

if (!$_SESSION["isLogged"]) {
    header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php");
}

$userId = $_SESSION['id'];
$idLotta = $_SESSION['sceltaN'];
$carteGiocatore = $_SESSION['scelte'];

$dataOra = date('Y-m-d H:i:s');

// Recupero delle info della lotta appena conclusa
$result = $connection->prepare("
    SELECT L.Exp, L.Premio, LC.IsVinta, LC.Data 
    FROM Lotte L
    JOIN Lotte_Combattute LC ON L.Id = LC.Id_lotta
    WHERE LC.Id_utente = ? AND LC.Id_lotta = ?
    ORDER BY LC.Data DESC
    LIMIT 1
");
$result->execute([$userId, $idLotta]);
$lotta = $result->fetch(PDO::FETCH_ASSOC);

// Recupero delle carte usate dal nemico durante la lotta
$resultNemico = $connection->prepare("
    SELECT C.Nome, C.Immagine 
    FROM Carte_Lotte CL
    JOIN Carte C ON CL.Id_carta = C.Id
    WHERE CL.Id_lotta = ?
");
$resultNemico->execute([$idLotta]);
$carteNemico = $resultNemico->fetchAll(PDO::FETCH_ASSOC);

// Recupero delle carte usate dal giocatore 
$carte = [];
if (!empty($carteGiocatore)) {
    $temporaneo = implode(',', array_fill(0, count($carteGiocatore), '?'));
    $resultCarte = $connection->prepare("SELECT Nome FROM Carte WHERE Id IN ($temporaneo)");
    $resultCarte->execute($carteGiocatore);
    $carte = $resultCarte->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Resoconto Lotta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
 
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
    <h1>Resoconto Lotta</h1>
    
    <?php if ($lotta): ?>
        <p><strong>Data:</strong> <?= htmlspecialchars($lotta['Data']) ?></p>
        <p><strong>Esito:</strong> <?= $lotta['IsVinta'] ? "Vittoria" : "Sconfitta" ?></p>
        <p><strong>Esperienza guadagnata:</strong> <?= htmlspecialchars($lotta['Exp']) ?></p>
        <p><strong>Premio:</strong> <?= htmlspecialchars($lotta['Premio']) ?></p>
        
        <!-- Dettagli del mazzo nemico -->
        <h2>Mazzo Avversario</h2>
        <div class="nemico-carte">
            <?php foreach ($carteNemico as $carta): ?>
                <div class="card-container">
                    <img src="<?= htmlspecialchars($carta['Immagine']) ?>" alt="<?= htmlspecialchars($carta['Nome']) ?>" height="100" />
                    <p><?= htmlspecialchars($carta['Nome']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Dettagli delle carte usate dal giocatore -->
        <h2>Carte Utilizzate da Te</h2>
        <ul>
            <?php foreach ($carte as $nomeCarta): ?>
                <li><?= htmlspecialchars($nomeCarta) ?></li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p>Lotta non trovata o dati mancanti.</p>
    <?php endif; ?>

    <hr>
    <a href="storico_lotte.php">Vedi storico lotte combattute</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

