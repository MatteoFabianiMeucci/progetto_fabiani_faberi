<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once("./connessione.php");
        session_start();
        require_once("./inizializzazione_sessione.php");
    ?>
    <!-- DA AGGIUNGERE: Navabar - menu dropdown(login, pacchetti, carte, lotte)-->
    <div>
        <?php if(!$_SESSION["isLogged"]):?>
            <a href="./login.php">login</a>
        <?php else:?>
            <a href="">profilo</a>
            <a href="">pacchetti</a>
            <a href="">carte</a>
            <a href="">lotte</a>
        <?php endif;?>
    <!--DA AGGIUNGERE: CARDS (pacchetti, carte, lotte)-->
    </div>
</body>
</html>