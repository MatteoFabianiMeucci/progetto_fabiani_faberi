<?php

    require_once("inizializzazione_sessione.php");
    require_once("./connessione.php");
    if(!$_SESSION["isLogged"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    }
    if($_SESSION["isAdmin"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/?err=admin");
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
                $_SESSION['lotta_finita'] = true;
                header("Location: http://localhost/progetto_fabiani_faberi/pages/lotta_completa.php");
            }
        }

        if ($utente['ps'][$utente['attiva']['Id']] <= 0) {
            $messaggio .= "<br> KO tua carta: " . $utente['attiva']['Nome'];
            if (count($utente['panchina']) > 0) {
                $utente['attiva'] = array_shift($utente['panchina']);
            } else {
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
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">GCC Pokémon Pocket</a>
        <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
            <img src="../images/layout/offcanvas_logo.png" alt="Menu Icon" style="width: 24px; height: 24px;">
        </button>
    </div>
</nav>

<div class="container">
    <h1 class="text-center mb-4">Lotta Pokémon – <?= htmlspecialchars($_SESSION["username"]) ?></h1>

    <div class="row mb-4 d-flex align-items-stretch">
        <!-- Carta Giocatore -->
        <div class="col-md-6">
            <div class="card text-center shadow-sm h-100">
                <h2>La tua carta:</h2>
                <img src="<?= $utente['attiva']['Immagine'] ?>" class="card-img-top" alt="Tua carta attiva">
                <div class="card-body">
                    <h5 class="card-title"><?= $utente['attiva']['Nome'] ?></h5>
                    <p class="card-text">PS: <?= $utente['ps'][$utente['attiva']['Id']] ?></p>
                    <form method="post">
                        <button type="submit" name="attacca" class="btn btn-success">Attacca!</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Carta Nemico -->
        <div class="col-md-6">
            <div class="card text-center shadow-sm h-100">
                <h2>Carta del nemico:</h2>
                <img src="<?= $nemico['attiva']['Immagine'] ?>" class="card-img-top" alt="Carta nemico attiva">
                <div class="card-body">
                    <h5 class="card-title"><?= $nemico['attiva']['Nome'] ?></h5>
                    <p class="card-text">PS: <?= $nemico['ps'][$nemico['attiva']['Id']] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Messaggio -->
    <?php if (!empty($messaggio)): ?>
        <div class="alert alert-info"><?= $messaggio ?></div>
    <?php endif; ?>

    <!-- Cambio con Panchina -->
    <h3>Cambia con una carta dalla panchina:</h3>
    <div class="d-flex flex-wrap gap-2 mb-4">
        <?php foreach ($utente['panchina'] as $i => $carta): ?>
            <?php if ($utente['ps'][$carta['Id']] > 0): ?>
                <form method="post">
                    <input type="hidden" name="cambia" value="1">
                    <input type="hidden" name="index" value="<?= $i ?>">
                    <button type="submit" class="btn btn-outline-secondary">
                        <?= $carta['Nome'] ?> (<?= $utente['ps'][$carta['Id']] ?> PS)
                    </button>
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
