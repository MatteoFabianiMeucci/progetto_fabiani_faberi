<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
    </head>
<body>
    <?php
        require_once("./inizializzazione_sessione.php");
        require_once("./connessione.php");
        if(!$_SESSION['isLogged'])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
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

    <div class="container my-4">
        
        
        <?php if($_SESSION["isAdmin"]): ?>
            <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Username</h5>
                <p class="card-text">
                    <?=$_SESSION["username"]?>
                </p>
            </div>
            </div>
            <div class = "mt-2 mb-4">
                <a href="./form_delete_user.php" class="btn btn-primary w-100 mb-2">Elimina e banna utente</a>
                <br>
                <a href="./form_unban_email.php" class="btn btn-primary w-100 mb-2">Ripristina una email</a>
            </div>
            
        <?php else: ?>
            <?php
                $query = "SELECT cast(sum(Exp) as signed) esperienza FROM lotte_combattute JOIN lotte ON (lotte_combattute.Id_lotta = lotte.Id) WHERE lotte_combattute.Id_utente = :id AND lotte_combattute.IsVinta = 1";
                $result = $connection->prepare($query);
                $result->bindValue(":id", $_SESSION['id']);
                if($result->execute()){
                    $result = $result->fetch(PDO::FETCH_ASSOC);
                    $esperienza = $result['esperienza'];
                    if($esperienza == null){
                        $esperienza = 0;
                    }
                    $esperienza;
                    $livello = 1;
                    $expPerLivello = 100;
                    while ($esperienza >= $expPerLivello) {
                        $esperienza -= $expPerLivello;
                        $livello++;
                        // Aumentiamo la difficoltà: ogni livello richiede il 20% di exp in più
                        $expPerLivello = ceil($expPerLivello * 1.2);
                    }
                } else {
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/profilo.php?err=500");
                }
                $query = "SELECT sum(Premio) soldi FROM lotte_combattute JOIN lotte ON (lotte_combattute.Id_lotta = lotte.Id) WHERE lotte_combattute.IsVinta = 1 AND lotte_combattute.Id_utente = :id";
                    $result = $connection->prepare($query);
                    $result->bindValue(":id", $_SESSION['id']);
                    $result->execute();
                    $result = $result->fetch(PDO::FETCH_ASSOC);
                    $soldi_guadagnati = $result['soldi'];

                    $query = "SELECT sum(Costo) soldi FROM pacchetti_aperti JOIN pacchetti ON (pacchetti_aperti.Id_pacchetto = pacchetti.Id) WHERE pacchetti_aperti.Id_utente = :id";
                    $result = $connection->prepare($query);
                    $result->bindValue(":id", $_SESSION['id']);
                    $result->execute();
                    $result = $result->fetch(PDO::FETCH_ASSOC);
                    $soldi_effettivi = $soldi_guadagnati - $result['soldi'];

                    $query = "SELECT Id_pacchetto FROM pacchetti_aperti JOIN pacchetti ON (pacchetti_aperti.Id_pacchetto = pacchetti.Id) WHERE pacchetti_aperti.Id_utente = :id ORDER BY Data";
                    $result = $connection->prepare($query);
                    $result->bindValue(":id", $_SESSION['id']);
                    $result->execute();
                    $result = $result->fetchAll(PDO::FETCH_ASSOC);
                    if(count($result) > 0){
                        $id_primo_pacchetto = $result[0]['Id_pacchetto'];
                    }else{
                        $id_primo_pacchetto = -1;
                    }
                    switch ($id_primo_pacchetto) {
                        case 1:
                            $soldi_effettivi += 10;
                            break;
                        case 2:
                            $soldi_effettivi += 15;
                            break;
                        default:
                            break;
                    }
            ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Username</h5>
                    <p class="card-text">
                        <?=$_SESSION["username"]?>
                    </p>
                    <h5 class="card-title">Pokedollari</h5>
                    <p class="card-text">
                        <b><?=$soldi_effettivi?> <span><img src="../images/layout/currency_icon.png" alt="pokedollari" class="currency"></span></b>
                    </p>
                    <h5 class="card-title">Livello: <?=$livello?></h5>
                    <p class="card-text">
                        <?php if(isset($_GET['err']) && $_GET['err'] == "500"): ?>
                            Si è verificato un problema
                        <?php else: ?>
                            <?="($esperienza/$expPerLivello exp)"?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <a href="form_new_username.php" class="btn btn-primary w-100 mb-2">Edit username</a>
                <a href="./carte.php" class="btn btn-secondary w-100 mb-2">Le tue carte</a>
                <a href="./pacchetti.php" class="btn btn-secondary w-100 mb-2">Apri un pacchetto</a>
                <a href="./seleziona_carte.php" class="btn btn-secondary w-100">Inizia una lotta</a>
            </div>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>