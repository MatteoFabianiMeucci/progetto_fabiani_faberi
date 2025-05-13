<?php
    require_once("inizializzazione_sessione.php");
    require_once("./connessione.php");
    if(!$_SESSION["isLogged"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
        }
    if($_SESSION["isAdmin"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/?err=admin");
    }

    $userId = $_SESSION["id"];
    unset($_SESSION['lotta_utente']);
    unset($_SESSION['lotta_finita']);

    // ottienimento 5 carte possedute casuali
    if (!isset($_SESSION['scelte']) || count($_SESSION['scelte']) != 5) {
        header("Location: http://localhost/progetto_fabiani_faberi/pages/seleziona_carte.php");
    }

    $temporaneo = implode(',', array_fill(0, count($_SESSION['scelte']), '?'));
    $query = "SELECT Carte.Id, Carte.Nome, Carte.PS, Carte.Immagine, Carte.Tipo, Carte.Debolezza, Carte.Attacco, a.Danno, a.Nome as nomeAttacco
        FROM Carte
        JOIN Attacchi a ON Carte.Attacco = a.Id
        WHERE Carte.Id IN ($temporaneo)";
    $result = $connection->prepare($query);
    $result->execute($_SESSION['scelte']);
    $carteUtente = $result->fetchAll(PDO::FETCH_ASSOC);

    if (count($carteUtente) < 1) {
        die("Non hai carte! Aggiungine prima.");
    }

    // ottenimento 5 carte casuali dal db per il nemico
    $carteNemico = $_SESSION['mazzoNemico'];

    // crea nuova partita per l'utente loggato
    $_SESSION['lotta_utente'] = [
        'utente' => [
            'attiva' => $carteUtente[0],
            'panchina' => array_slice($carteUtente, 1),
            'ps' => array_column($carteUtente, 'PS', 'Id'),
            'nomeAttacco' => array_column($carteUtente, 'nomeAttacco', 'Id')
        ],
        'nemico' => [
            'attiva' => $carteNemico[0],
            'panchina' => array_slice($carteNemico, 1),
            'ps' => array_column($carteNemico, 'PS', 'Id'),
            'nomeAttacco' => array_column($carteNemico, 'nomeAttacco', 'Id')
        ]
    ];

    header("Location: http://localhost/progetto_fabiani_faberi/pages/lotte.php");
?>