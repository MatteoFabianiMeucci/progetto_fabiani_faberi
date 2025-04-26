<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once("./inizializzazione_sessione.php");
        require_once("./connessione.php");
        if(!$_SESSION['isLogged'])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    ?>
    <p>Username: <?=$_SESSION["username"]?> <span><a href="form_new_username.php">edit</a></span></p> 
    
    <?php if($_SESSION["isAdmin"]): ?>
        <p>Ruolo: Amministratore</p>
        <a href="./form_delete_user.php">Elimina e banna utente</a>
        <br>
        <a href="./form_unban_email.php">Ripristina una email</a>
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
                $temp = $esperienza;
                $livello = 1;
                $expPerLivello = 100;
                while ($temp >= $expPerLivello) {
                    $temp -= $expPerLivello;
                    $livello++;
                    // Aumentiamo la difficoltà: ogni livello richiede il 20% di exp in più
                    $expPerLivello = ceil($expPerLivello * 1.2);
                }
            }else {
                header("Location: http://localhost/progetto_fabiani_faberi/pages/profilo.php?err=500");
            }
        ?>
        <p>
            livello:
            <?php if(isset($_GET['err']) && $_GET['err'] == "500"):?>
                <?="Si è verificato un problema"?>
            <?php else: ?>
                <?=$livello . " ($esperienza/$expPerLivello exp)"?>
            <?php endif; ?>
        </p>
        <p>Ruolo: Utente</p>
        <a href="./carte.php">Le tue carte</a>
        <br>
        <a href="./pacchetti.php">Apri un pacchetto</a>
    <?php endif; ?>
    <br>
    <a href="./index.php">torna alla home</a>
</body>
</html>