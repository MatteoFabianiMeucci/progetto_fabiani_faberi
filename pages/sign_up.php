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
        <form action="./inserimento_utente.php" method="post">
        <label><b>Inserisci i dati dell'account da creare</b></label>
            <br> 
            <label>Username</label>
            <br>
            <input type="text" name = "username" required>
            <br>
            <label>Password</label>
            <br>
            <input type="text" name = "password" required>
            <br>
            <br>
            <input type="submit" value="Invia">
        </form>
    </div>
</body>
</html>