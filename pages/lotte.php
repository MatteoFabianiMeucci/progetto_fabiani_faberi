<?php

    require_once("inizializzazione_sessione.php");
                require_once("./connessione.php");
                if(!$_SESSION["isLogged"]){
                header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
                }
    if (!isset($_SESSION['lotta_utente'])) {
        header("Location: http://localhost/progetto_fabiani_faberi/pages/setUpLotte.php");
    }

    $lotta = &$_SESSION['lotta_utente'];
    $utente = &$lotta['utente'];
    $nemico = &$lotta['nemico'];

    $messaggio = "";

    function calcolaDanno($attaccante, $difensore) {
        $danno = $attaccante['Danno'];
        if ($attaccante['Tipo'] == $difensore['Debolezza']) {
            $danno += 20;
        }
        return $danno;
    }

    // attacco
    if (isset($_POST['attacca'])) {
        $dannoUtente = calcolaDanno($utente['attiva'], $nemico['attiva']);
        $dannoNemico = calcolaDanno($nemico['attiva'], $utente['attiva']);

        $nemico['ps'][$nemico['attiva']['Id']] -= $dannoUtente;
        $utente['ps'][$utente['attiva']['Id']] -= $dannoNemico;

        $messaggio = "Hai usato l'attacco: " . $utente['nomeAttacco'][$utente['attiva']['Id']] . " infliggendo $dannoUtente danni. <br> Il nemico ha usato l'attacco: " . $nemico['nomeAttacco'][$nemico['attiva']['Id']] . " infliggendo $dannoNemico danni.";
       

        // gestione KO
        if ($nemico['ps'][$nemico['attiva']['Id']] <= 0) {
            $messaggio .= "<br> KO: " . $nemico['attiva']['Nome'] . "!";
            if (count($nemico['panchina']) > 0) {
                $nemico['attiva'] = array_shift($nemico['panchina']);
            } else {
                $messaggio .= "<br> Hai VINTO!";
            }
        }

        if ($utente['ps'][$utente['attiva']['Id']] <= 0) {
            $messaggio .= "<br> KO tua carta: " . $utente['attiva']['Nome'];
            if (count($utente['panchina']) > 0) {
                $utente['attiva'] = array_shift($utente['panchina']);
            } else {
                $messaggio .= "<br> Hai PERSO!";
            }
        }
    }

    // cambio carta
    if (isset($_POST['cambia']) && isset($_POST['index'])) {
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
</head>
<body>
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
</body>
</html>