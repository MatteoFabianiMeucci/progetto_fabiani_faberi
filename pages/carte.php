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

        <div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Filtra le tue carte</h3>
        </div>
        <div class="card-body">
            <form method="post" action="carte_filtrate.php">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tipo" class="form-label">Tipo:</label>
                        <select id="tipo" name="tipo" class="form-select">
                            <option value="">Nessun filtro</option>
                            <?php foreach ($tipi as $tipo): ?>
                                <option value="<?= $tipo['Id'] ?>"><?= $tipo['Tipo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="debolezza" class="form-label">Debolezza:</label>
                        <select id="debolezza" name="debolezza" class="form-select">
                            <option value="">Nessun filtro</option>
                            <?php foreach ($tipi as $tipo): ?>
                                <option value="<?= $tipo['Id'] ?>"><?= $tipo['Tipo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="pacchetto" class="form-label">Pacchetto:</label>
                        <select id="pacchetto" name="pacchetto" class="form-select">
                            <option value="">Nessun filtro</option>
                            <?php foreach ($pacchetti as $pacchetto): ?>
                                <option value="<?= $pacchetto['Id'] ?>"><?= $pacchetto['Nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="carte_non_possedute" class="form-label">Stato di proprietà:</label>
                        <select id="carte_non_possedute" name="carte_non_possedute" class="form-select">
                            <option value="">Nessun filtro</option>
                            <option value="possedute">Carte possedute</option>
                            <option value="mancanti">Carte non possedute</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome:</label>
                        <input id="nome" type="text" name="nome" class="form-control" placeholder="Inserisci nome carta">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Filtra</button>
                </div>
            </form>
        </div>
    </div>
</div>


        <h2>Le tue carte:</h2>
        <?php
            $query = "SELECT carte.Immagine 
                    FROM carte 
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