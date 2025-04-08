<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once("./inizializzazione_sessione.php");
           
        if(!$_SESSION["isLogged"] || !$_SESSION["isAdmin"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    ?>
    <div>
        <form action="./delete_user.php" method="post">
        <label><b>Digita l'username dell'utente da eliminare</b></label>
            <br>
            <br>
            <label>Username</label>
            <br>
            <input type="text" name = "username" required>
            
            <?php if(isset($_GET['err']) && $_GET['err'] == 404): ?>
                <label><b>!!! Utente non trovato, ritenta !!!</b></label>
            <?php elseif(isset($_GET['err']) && $_GET['err'] == 500): ?>
                <label><b>!!! Si è verificato un problema, ritenta !!!</b></label>
            <?php endif; ?>

            <br>
            <br>
            <input type="submit" value="Invia">
        </form>
        <a href="./index.php">torna alla home</a>
    </div>
</body>
</html>