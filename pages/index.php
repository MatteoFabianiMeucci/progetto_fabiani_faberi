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
        require_once("./inizializzazione_sessione.php");
    ?>
    <!-- DA AGGIUNGERE: Navabar - menu dropdown(login, pacchetti, carte, lotte)-->
    <div>
        <?php if(!$_SESSION["isLogged"]):?>
            <a href="./login.php">login</a>
            <a href="./sign_up.php">sign up</a>
        <?php else:?>
            <p>Benvenuto, <?=$_SESSION["username"]?>!</p>
            <a href="./profilo.php">profilo</a>
            <a href="./logout.php">logout</a>
            <?php if(!$_SESSION["isAdmin"]):?>
                <a href="./pacchetti.php">pacchetti</a>
                <a href="./carte">carte</a>
            <?php else:?>
                <a href="form_delete_user.php">elimina un utente</a>
            <?php endif;?>
            <!--<a href="">lotte</a>-->
        <?php endif;?>
    <!--DA AGGIUNGERE: CARDS (pacchetti, carte, lotte)-->
    </div>
</body>
</html>