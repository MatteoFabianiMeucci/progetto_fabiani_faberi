<?php
require_once("inizializzazione_sessione.php");
require_once("./connessione.php");
if(!$_SESSION["isLogged"]){
   header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
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
        header("Location: http://localhost/progetto_fabiani_faberi/pages/setUpLotte.php");
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Seleziona le tue carte</title>
</head>
<body>
<?php

echo '<h1>Ciao ' . $_SESSION["username"] . ', scegli 5 carte per la lotta</h1>';
echo '<form method="post">';

// ciclo sulle carte per visualizzarle tutte
foreach ($carte as $carta) {
    echo '<label">';
    echo '<img src="' . $carta['Immagine'] . '" height="100"><br>';
    echo '<input type="checkbox" name="scelte[]" value="' . $carta['Id'] . '">';
    echo $carta['Nome'] . ' (' . $carta['Danno'] . ' danni)';
    echo '</label>';
}

echo '<br><br>';
echo '<button type="submit">Avvia lotta!</button>';
echo '</form>';
// style="display: inline-block; margin: 10px; text-align: center;
?>


</body>
</html>