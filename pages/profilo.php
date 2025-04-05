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
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
        
        
    ?>
    <p>Username: <?=$_SESSION["username"]?> <span><a href="form_new_username.php">edit</a></span></p> 
    
    <?php if($_SESSION["isAdmin"]): ?>
        <p>Ruolo: Amministratore</p>
    <?php else: ?>
        <p>Ruolo: Utente</p>
    <?php endif; ?>
    
    <a href="./carte.php">Le tue carte</a>
</body>
</html>