<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Carte Utente</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <li class="nav-item"><a class="nav-link" href="./seleziona_carte.php">Lotte</a></li>
                    <?php else:?>
                        <li class="nav-item"><a class="nav-link" href="form_delete_user.php">Elimina un utente</a></li>
                        <li class="nav-item"><a class="nav-link" href="./form_unban_email.php">Ripristina una email</a></li>
                    <?php endif;?>
                    
                <?php endif;?>
            </ul>
        </div>
    </div>

        <form method="post" action="carte_filtrate.php">
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

            <br><label>Stato di proprieta': </label>
            <select name="carte_non_possedute">
                <option value="">Nessun filtro</option>
                <option value="possedute">Carte possedute</option>
                <option value="mancanti">Carte non possedute</option>
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
            <img class="displayed_cards" src="<?= $carta['Immagine'] ?>">
        <?php endforeach; ?>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>