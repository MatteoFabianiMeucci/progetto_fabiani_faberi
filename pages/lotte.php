<?php

    require_once("inizializzazione_sessione.php");
    require_once("./connessione.php");
    if(!$_SESSION["isLogged"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
    }
    if (!isset($_SESSION['lotta_utente'])) {
        header("Location: http://localhost/progetto_fabiani_faberi/pages/setUp_lotte.php");
    }

    if(!isset($_SESSION['sceltaN'])){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/scegli_mazzo.php");
    }

    $lotta = &$_SESSION['lotta_utente'];
    $utente = &$lotta['utente'];
    $nemico = &$lotta['nemico'];
    $lotta_finita = isset($_SESSION['lotta_finita']);

    $messaggio = "";

    function calcolaDanno($attaccante, $difensore) {
        $danno = $attaccante['Danno'];
        if ($attaccante['Tipo'] == $difensore['Debolezza']) {
            $danno += 20;
        }
        return $danno;
    }

    // attacco
    if (isset($_POST['attacca']) && !$lotta_finita){
        $dannoUtente = calcolaDanno($utente['attiva'], $nemico['attiva']);
        $dannoNemico = calcolaDanno($nemico['attiva'], $utente['attiva']);
        
        $nemico['ps'][$nemico['attiva']['Id']] = max(0, $nemico['ps'][$nemico['attiva']['Id']] - $dannoUtente);
        $utente['ps'][$utente['attiva']['Id']] = max(0, $utente['ps'][$utente['attiva']['Id']] - $dannoNemico);
        

        $messaggio = "Hai usato l'attacco: " . $utente['nomeAttacco'][$utente['attiva']['Id']] . " infliggendo $dannoUtente danni. <br> Il nemico ha usato l'attacco: " . $nemico['nomeAttacco'][$nemico['attiva']['Id']] . " infliggendo $dannoNemico danni.";
       

        // gestione KO
        if ($nemico['ps'][$nemico['attiva']['Id']] <= 0) {
            $messaggio .= "<br> KO: " . $nemico['attiva']['Nome'] . "!";
            if (count($nemico['panchina']) > 0) {
                $nemico['attiva'] = array_shift($nemico['panchina']);
            } else {
                $messaggio .= "<br> Hai VINTO!";
                $_SESSION['lotta_finita'] = true;
                header("Location: http://localhost/progetto_fabiani_faberi/pages/lotta_completa.php");
            }
        }

        if ($utente['ps'][$utente['attiva']['Id']] <= 0) {
            $messaggio .= "<br> KO tua carta: " . $utente['attiva']['Nome'];
            if (count($utente['panchina']) > 0) {
                $utente['attiva'] = array_shift($utente['panchina']);
            } else {
                $messaggio .= "<br> Hai PERSO!";
                $_SESSION['lotta_finita'] = false;
                header("Location: http://localhost/progetto_fabiani_faberi/pages/lotta_completa.php");
            }
        }
    }

    // cambio carta
    if (isset($_POST['cambia']) && isset($_POST['index']) && !$lotta_finita) {
        $i = (int)$_POST['index'];
        if (isset($utente['panchina'][$i])) {
            $vecchia = $utente['attiva'];
            $utente['attiva'] = $utente['panchina'][$i];
            $utente['panchina'][$i] = $vecchia;
            $messaggio = "Cambio con " . $utente['attiva']['Nome'];
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Lotta Pokémon</title>
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
    <h1>Lotta Pokémon – <?= htmlspecialchars($_SESSION["username"]) ?></h1>

    <h2>Tua Carta Attiva</h2>
    <p><?= $utente['attiva']['Nome'] ?> – PS: <?= $utente['ps'][$utente['attiva']['Id']] ?></p>
    <img src="<?= $utente['attiva']['Immagine'] ?>" height="100">

    <form method="post">
        <button type="submit" name="attacca">Attacca!</button>
    </form>

    <h3>Cambio con Panchina</h3>
    <form method="post">
    <?php foreach ($utente['panchina'] as $i => $carta): ?>
    <?php if ($utente['ps'][$carta['Id']] > 0): ?>
        <form method="post" style="display: inline;">
            <input type="hidden" name="cambia" value="1">
            <input type="hidden" name="index" value="<?= $i ?>">
            <button type="submit">
                <?= $carta['Nome'] ?> (<?= $utente['ps'][$carta['Id']] ?> PS)
            </button>
        </form>
    <?php endif; ?>
<?php endforeach; ?>
    </form>

    <h2>Nemico Attivo</h2>
    <p><?= $nemico['attiva']['Nome'] ?> – PS: <?= $nemico['ps'][$nemico['attiva']['Id']] ?></p>
    <img src="<?= $nemico['attiva']['Immagine'] ?>" height="100">

    <p><strong><?= $messaggio ?></strong></p>

    <form method="get" action="setup.php">
        <button type="submit">Nuova Lotta</button>
    </form>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>