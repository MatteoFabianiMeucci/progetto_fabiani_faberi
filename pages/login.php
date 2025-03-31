<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        require_once("./inizializzazione_sessione.php");
           
        if($_SESSION["isLogged"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    ?>
    <div>
        <form action="./autenticazione.php" method="post">
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
            <a href="sign_up.php">Non hai un account?</a>
            <br>
            <br>
            <input type="submit" value="Invia">
        </form>
    </div>
</body>
</html>