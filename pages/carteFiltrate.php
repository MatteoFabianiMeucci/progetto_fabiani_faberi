<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Filtrate</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <?php
        require_once("inizializzazione_sessione.php");
        require_once("connessione.php");

        if (!$_SESSION["isLogged"]) {
            header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
        }

        $conditions = [];
        $params = [];

        if (!empty($_POST['carte_non_possedute'])) {
            $conditions[] = "NOT EXISTS (
                                SELECT * 
                                FROM carte 
                                JOIN carte_possedute ON carte.Id = carte_possedute.Id_carta 
                                JOIN utenti ON carte_possedute.id_utente = utenti.Id 
                                WHERE utenti.username = :username
                                AND carte.Id = c.Id
                            )";
            $params[':username'] = $_SESSION['username'];
        }

        if (!empty($_POST['nome'])) {
            $conditions[] = "nome LIKE :nome";
            $params[':nome'] = '%' . $_POST['nome'] . '%';
        }

        if (!empty($_POST['tipo'])) {
            $conditions[] = "tipo = :tipo";
            $params[':tipo'] = $_POST['tipo'];
        }

        if (!empty($_POST['debolezza'])) {
            $conditions[] = "debolezza = :debolezza";
            $params[':debolezza'] = $_POST['debolezza'];
        }

        if (!empty($_POST['pacchetto'])) {
            $conditions[] = "pacchetto = :pacchetto";
            $params[':pacchetto'] = $_POST['pacchetto'];
        }

        $query = "SELECT * FROM carte c";

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $connection->prepare($query);
        $result->execute($params);
    ?>

    <h2>Carte trovate:</h2>
    <?php 
        $carte = $result->fetchAll(PDO::FETCH_ASSOC);
        if (count($carte) === 0): 
    ?>
        <p>Nessuna carta trovata con i filtri selezionati.</p>
    <?php else: ?>
        <?php foreach ($carte as $carta): ?>
            <img class="cards" src="<?= $carta['Immagine'] ?>" alt="Carta">
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>