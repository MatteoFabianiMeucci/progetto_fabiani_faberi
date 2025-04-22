<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Carte Utente</title>
</head>
<body>
    <div>
        <?php
            require_once("inizializzazione_sessione.php");
            require_once("connessione.php");

            if (!$_SESSION["isLogged"]) {
                header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
            }

            $username = $_SESSION['username'];

            // Recupero dati da Tipo e Pacchetti
            $tipi = $connection->query("SELECT * FROM Tipo")->fetchAll(PDO::FETCH_ASSOC);
            $pacchetti = $connection->query("SELECT * FROM Pacchetti")->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <form method="post" action="carteFiltrate.php">
            <h1>Filtra le tue carte</h1><br>

            <label>Tipo:</label>
            <select name="tipo">
                <option value="">Nessun filtro</option>
                <?php foreach ($tipi as $tipo): ?>
                    <option value="<?= $tipo['Id'] ?>"><?= $tipo['Tipo'] ?></option>
                <?php endforeach; ?>
            </select>

            <br><label>Debolezza:</label>
            <select name="debolezza">
                <option value="">Nessun filtro</option>
                <?php foreach ($tipi as $tipo): ?>
                    <option value="<?= $tipo['Id'] ?>"><?= $tipo['Tipo'] ?></option>
                <?php endforeach; ?>
            </select>

            <br><label>Pacchetto:</label>
            <select name="pacchetto">
                <option value="">Nessun filtro</option>
                <?php foreach ($pacchetti as $pacchetto): ?>
                    <option value="<?= $pacchetto['Id'] ?>"><?= $pacchetto['Nome'] ?></option>
                <?php endforeach; ?>
            </select>

            <br><label>Nome:</label>
            <input type="text" name="nome">

            <br><input type="submit" value="Filtra">
        </form>

        <h2>Le tue carte:</h2>
        <?php
            $query = "SELECT * FROM carte 
                      JOIN carte_possedute ON carte.Id = carte_possedute.Id_carta 
                      JOIN utenti ON carte_possedute.id_utente = utenti.Id 
                      WHERE utenti.username = :username";
            $result = $connection->prepare($query);
            $result->bindValue(':username', $username);
            $result->execute();

            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $carta):
        ?>
            <img class="cards" src="<?= $carta['Immagine'] ?>">
        <?php endforeach; ?>
    </div>
</body>
</html>