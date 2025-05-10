<?php
require_once("inizializzazione_sessione.php");
require_once("./connessione.php");

if (!$_SESSION["isLogged"]) {
    header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php");
}

// Dati della lotta
$userId = $_SESSION['id'];
$idLotta = $_SESSION['sceltaN']; // ID lotta scelta
$vinta = $_POST['lotta_finita']; // true = vittoria, false = sconfitta
$dataOra = date('Y-m-d H:i:s');

// Recupero info premio/exp della lotta  
$result = $connection->prepare("SELECT Exp, Premio FROM Lotte WHERE Id = ?");
$result->execute([$idLotta]);
$infoLotta = $result->fetch(PDO::FETCH_ASSOC);

// Inserimento della lotta come completata
$insert = $connection->prepare("
    INSERT INTO Lotte_Combattute (Id_utente, Id_lotta, Data, IsVinta)
    VALUES (?, ?, ?, ?)
");
$insert->execute([$userId, $idLotta, $dataOra, $vinta]);

header("Location: http://localhost/progetto_fabiani_faberi/pages/resoconto_lotta.php");
?>
