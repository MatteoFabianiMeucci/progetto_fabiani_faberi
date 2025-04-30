<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Filtrate</title>
    <link rel="stylesheet" href="../styles/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        switch($_POST['carte_non_possedute']){
            case 'possedute':
                $conditions[] = " EXISTS (
                    SELECT * 
                    FROM carte 
                    JOIN carte_possedute ON carte.Id = carte_possedute.Id_carta 
                    JOIN utenti ON carte_possedute.id_utente = utenti.Id 
                    WHERE utenti.username = :username
                    AND carte.Id = c.Id
                )";
                $params[':username'] = $_SESSION['username'];
                break;
            case 'mancanti':
                $conditions[] = " NOT EXISTS (
                    SELECT * 
                    FROM carte 
                    JOIN carte_possedute ON carte.Id = carte_possedute.Id_carta 
                    JOIN utenti ON carte_possedute.id_utente = utenti.Id 
                    WHERE utenti.username = :username
                    AND carte.Id = c.Id
                )";
                $params[':username'] = $_SESSION['username'];
                break;
            default:
                break;
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
                    <?php if(!$_SESSION["isAdmin"]):?>
                        <li class="nav-item"><a class="nav-link" href="./pacchetti.php">Pacchetti</a></li>
                        <li class="nav-item"><a class="nav-link" href="./carte.php">Carte</a></li>
                    <?php else:?>
                        <li class="nav-item"><a class="nav-link" href="form_delete_user.php">Elimina un utente</a></li>
                        <li class="nav-item"><a class="nav-link" href="./form_unban_email.php">Ripristina una email</a></li>
                    <?php endif;?>
                    <!--<li class="nav-item"><a class="nav-link" href="#">Lotte</a></li>-->
                <?php endif;?>
            </ul>
        </div>
    </div>

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
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>