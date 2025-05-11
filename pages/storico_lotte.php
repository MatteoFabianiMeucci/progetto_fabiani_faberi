<?php
require_once("inizializzazione_sessione.php");
require_once("./connessione.php");

if (!$_SESSION["isLogged"]) {
    header("Location: ./login.php");
    exit;
}

$userId = $_SESSION['id'];

// Recupero di tutte le lotte combattute dall'utente
$result = $connection->prepare("
    SELECT LC.Id_lotta, LC.Data, LC.IsVinta, L.Exp, L.Premio
    FROM Lotte_Combattute LC
    JOIN Lotte L ON LC.Id_lotta = L.Id
    WHERE LC.Id_utente = ?
    ORDER BY LC.Data DESC
");
$result->execute([$userId]);
$lotte = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Storico Lotte Combattute</title>
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
                    <?php else:?>
                        <li class="nav-item"><a class="nav-link" href="form_delete_user.php">Elimina un utente</a></li>
                        <li class="nav-item"><a class="nav-link" href="./form_unban_email.php">Ripristina una email</a></li>
                    <?php endif;?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <h1 class="hs">Storico delle Lotte Combattute</h1>

    <?php if (count($lotte) > 0): ?>
        <!-- Ciclo per creare una tabella per ogni lotta -->
        <?php foreach ($lotte as $lotta): ?>
            <div class="sezione-lotta">
                <h2>Lotta del <?= htmlspecialchars($lotta['Data']) ?></h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Esito</th>
                            <th>Esperienza guadagnata</th>
                            <th>Premio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $lotta['IsVinta'] ? "Vittoria" : "Sconfitta" ?></td>
                            <?php if (isset($_SESSION['lotta_finita']) && $_SESSION['lotta_finita'] === true): ?>
                            <td><?= htmlspecialchars($lotta['Exp']) ?></td>
                            <td><?= htmlspecialchars($lotta['Premio']) ?></td>
                            <?php else: ?>
                                <td>0</td>
                                <td>Nessun premio</td>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>

                <?php
                    // Recupero delle carte nemiche associate alla lotta
                    $resultNemico = $connection->prepare("
                        SELECT C.Nome, C.Immagine
                        FROM Carte_Lotte CL
                        JOIN Carte C ON CL.Id_carta = C.Id
                        WHERE CL.Id_lotta = ?
                    ");
                    $resultNemico->execute([$lotta['Id_lotta']]);
                    $carteNemico = $resultNemico->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="text-center">
                    <h5>Carte Nemiche:</h5>
                    <?php if (count($carteNemico) > 0): ?>
                        <div class="row d-flex justify-content-center">
                            <?php foreach ($carteNemico as $carta): ?>
                                <div class="col-2 d-flex justify-content-center">
                                    <img class="img-fluid" src="<?= htmlspecialchars($carta['Immagine']) ?>" alt="<?= htmlspecialchars($carta['Nome']) ?>" style="width: 80%; height: auto; margin-bottom: 10px;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>Nessuna carta nemica registrata.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nessuna lotta combattuta ancora.</p>
    <?php endif; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

