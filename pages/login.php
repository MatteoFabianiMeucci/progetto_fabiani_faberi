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
           
        if($_SESSION["isLogged"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    
        
    ?>
    <div>
        <form action="./autenticazione.php" method="post">
            <?php if(isset($_GET['err']) && $_GET['err'] == 404): ?>
                <label><b>!!! Account non trovato, ritenta !!!</b></label>
                <br><br><br>
            <?php endif; ?>
            
        <label><b>Digita le credenziali del tuo account</b></label>
            <br> 
            <label>Username</label>
            <br>
            <input type="text" name = "username" required>
            <br>
            <label>Password</label>
            <br>
            <input type="text" name = "password" required>
            <br>
            <label>Accesso come admin</label>
            <input type="checkbox" name="admin">
            <br>
            <a href="sign_up.php">Non hai un account?</a>
            <br>
            <br>
            <input type="submit" value="Invia">
        </form>
        <a href="./index.php">torna alla home</a>
    </div>
</body>
</html>