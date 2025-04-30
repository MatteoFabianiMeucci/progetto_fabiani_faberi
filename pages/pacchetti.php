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
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
        
        
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
            <p><b>Hai <?=$soldi_effettivi?> monete</b></p>
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
            <?php foreach ($connection->query($query) as $row):?>
                <?php 
                    if($isPrimoPacchetto){
                        $costo = 0;
                    }else{
                        $costo = $row['Costo'];
                    }
                ?>
                <form action="apertura_pacchetto.php" method="post">
                    <img src="<?=$row['Immagine']?>" alt="" class = "packs">
                    <br>
                    <label for=""><b>Costo: <?=$costo?></b></label>
                    <br>
                    <?php if($soldi_effettivi >= $costo):?>
                        <input type="submit" value="Apri pacchetto!">
                    <?php else:?>
                        <input type="submit" value="Apri pacchetto!" disabled>
                    <?php endif;?>
                    <input type="hidden" name="id_pacchetto" value = "<?=$row['Id']?>">
                </form>
            <?php endforeach;?>
        </div>
    <?php else: ?>
        <div>
            <?php $carte = $_SESSION['carte_pacchetto']; ?>
            <h1>CARTE TROVATE</h1>
            <?php for($i = 0; $i < count($carte); $i++):?>
                <div>
                    <img src="<?=$carte[$i]['Immagine']?>" alt="" class = "cards">
                    <?php
                        $id_carta = $carte[$i]['Id'];
                        $query = "SELECT * FROM Carte_Possedute WHERE Id_utente = :id_utente AND Id_carta = :id_carta";
                        $result = $connection->prepare($query);
                        $result->bindValue(":id_carta", $id_carta);
                        $result->bindValue(":id_utente", $_SESSION['id']);
                        if($result->execute()){
                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            if(count($row) == 0){
                                $query = "INSERT INTO Carte_Possedute(Id_utente, Id_carta) VALUES (:id_utente, :id_carta)";
                                $result = $connection->prepare($query);
                                $result->bindValue(":id_utente", $_SESSION['id']);
                                $result->bindValue(":id_carta", $id_carta);
                                $result->execute();
                            }else{
                                echo "<p>Possiedi gia' ".$carte[$i]["Nome"]."</p>";
                            }
                        }else{
                            header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php?err=500");
                        }
                    ?>
                </div>
            <?php endfor;?>
        </div>
        <?php unset($_SESSION['carte_pacchetto']);?>
        <a href="./index.php">torna alla home</a>
        <a href="./pacchetti.php">torna ai pachetti</a>
    <?php endif; ?>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
