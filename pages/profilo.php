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
        require_once("inizializzazione_sessione.php");
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
        <p>Ruolo: Utente</p>
        <a href="./carte.php">Le tue carte</a>
    <?php endif; ?>
    <br>
    <a href="./index.php">torna alla home</a>
</body>
</html>