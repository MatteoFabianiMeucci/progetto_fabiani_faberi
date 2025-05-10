<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
        require_once("./connessione.php");
        require_once("./inizializzazione_sessione.php");
        if(!$_SESSION["isLogged"])
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

    <?php if(!isset($_SESSION['carte_pacchetto'])): ?>
        <div>
            <?php if(isset($_GET['err']) && $_GET['err'] == 404):?>
                <label><b>!!! Pacchetto inesistente, ritenta !!!</b></label>
                <br>
            <?php endif;?>
            <?php 
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
            <div class="card shadow-sm my-2 w-25 text-center">
                <div class="card-body">
                        <p class="card-text">
                            <b>Pokedollari: <?=$soldi_effettivi?> <span><img src="../images/layout/currency_icon.png" alt="pokedollari" class="currency"></span></b>
                        </p>
                </div>
            </div>
            <?php
                $isPrimoPacchetto = false;
                $query = "SELECT count(*) numPacchetti FROM pacchetti_aperti JOIN pacchetti ON (pacchetti_aperti.Id_pacchetto = pacchetti.Id) JOIN utenti ON (pacchetti_aperti.Id_utente = utenti.Id) WHERE utenti.Username = :username";
                $result = $connection->prepare($query);
                $result->bindValue(":username", $_SESSION['username']);
                if($result->execute()){
                    $result = $result->fetch(PDO::FETCH_ASSOC);
                    $numPacchetti = $result['numPacchetti'];
                    if($numPacchetti == 0){
                        $isPrimoPacchetto = true;  
                    }
                }else{
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php?err=500");
                }
                $query = "SELECT * FROM Pacchetti"; 
            ?>
            <div class="container">
                <div class="row">
                    <?php foreach ($connection->query($query) as $row):?>
                        <?php 
                            if($isPrimoPacchetto){
                                $costo = 0;
                            }else{
                                $costo = $row['Costo'];
                            }
                        ?>
                        <div class="col-md-4 mb-4">
                            <form action="apertura_pacchetto.php" method="post" class="text-center">
                                <img src="<?=$row['Immagine']?>" alt="" class="packs img-fluid">
                                <br>
                                <label for=""><b>Costo: <?=$costo?></b></label>
                                <br>
                                <?php if($soldi_effettivi >= $costo):?>
                                    <input type="submit" value="Apri pacchetto!" class="btn btn-primary">
                                <?php else:?>
                                    <input type="submit" value="Apri pacchetto!" class="btn btn-primary" disabled>
                                <?php endif;?>
                                <input type="hidden" name="id_pacchetto" value="<?=$row['Id']?>">
                            </form>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container text-center">
            <div class="row">
                <?php $carte = $_SESSION['carte_pacchetto']; ?>
                <h1>CARTE TROVATE</h1>
                <?php for($i = 0; $i < count($carte); $i++):?>
                    <div class="col-md-4 mb-4 text-center card-shower">
                        <div>
                            <!-- GG  -->
                            <img src="../images/cards/back.webp" data-card='<?=$carte[$i]['Immagine']?>' alt="" class="displayed_cards img-fluid">
                            <?php
                                $id_carta = $carte[$i]['Id'];
                                $query = "SELECT * FROM Carte_Possedute WHERE Id_utente = :id_utente AND Id_carta = :id_carta";
                                $result = $connection->prepare($query);
                                $result->bindValue(":id_carta", $id_carta);
                                $result->bindValue(":id_utente", $_SESSION['id']);
                                if($result->execute()){
                                    $row = $result->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                    <?php if(count($row) == 0):?>
                                        <?php
                                        $query = "INSERT INTO Carte_Possedute(Id_utente, Id_carta) VALUES (:id_utente, :id_carta)";
                                        $result = $connection->prepare($query);
                                        $result->bindValue(":id_utente", $_SESSION['id']);
                                        $result->bindValue(":id_carta", $id_carta);
                                        $result->execute();
                                    ?>
                                    <?php else:?>
                                        <div data-card=<?=$carte[$i]['Immagine']?> class="hide-desc card shadow-sm mx-auto my-2 w-75 text-center">
                                            <div class="card-body">
                                                <p class="card-text">Possiedi gia' <?=$carte[$i]["Nome"]?></p>
                                            </div>
                                        </div>
                                        
                                    <?php endif;?>
                                    <?php
                                }else{
                                    header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php?err=500");
                                }
                            ?>
                        </div>
                    </div>
                <?php endfor;?>
            </div>
            <a href="./pacchetti.php" class="btn btn-primary w-50  mb-2">torna ai pachetti</a>
        </div>
        <?php unset($_SESSION['carte_pacchetto']);?>
        
    <?php endif; ?>
    <!-- Bootstrap JS Bundle -->
    <script src="../js/show-cards.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
