<?php
    require_once("inizializzazione_sessione.php");
    require_once("./connessione.php");

    if(!$_SESSION["isLogged"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    }elseif($_SESSION["isAdmin"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/?err=admin");
    }elseif(!isset($_SESSION["lotta_finita"])){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/scegli_mazzo.php");
    }else{

    // Dati della lotta
    $userId = $_SESSION['id'];
    $idLotta = $_SESSION['sceltaN']; // ID lotta scelta
    $vinta = $_SESSION['lotta_finita'] ? 1 : 0; // true = vittoria, false = sconfitta
    $dataOra = date('Y-m-d H:i:s');

    // Inserimento della lotta come completata
    $insert = $connection->prepare("
        INSERT INTO Lotte_Combattute (Id_utente, Id_lotta, Data, IsVinta)
        VALUES (?, ?, ?, ?)
    ");
    $insert->execute([$userId, $idLotta, $dataOra, $vinta]);
    header("Location: http://localhost/progetto_fabiani_faberi/pages/resoconto_lotta.php");
}
?>
