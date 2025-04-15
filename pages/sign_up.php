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
        <?php if(isset($_GET['err']) && $_GET['err'] == 403): ?>
            <label><b>!!! Username gia' utilizzato, ritenta !!!</b></label>
            <br><br><br>
        <?php elseif (isset($_GET['err']) && $_GET['err'] == 401): ?>
            <label><b>!!! La mail è sottoposta ad un ban !!!</b></label>
            <br><br><br>
        <?php endif; ?>
        
        <label><b>Inserisci i dati dell'account da creare</b></label>
            <br> 
            <label>Username</label>
            <br>
            <input type="text" name = "username" required>
            <br>
            <label>Password</label>
            <br>
            <input type="password" name = "password" required>
            <br>
            <label>Email</label>
            <br>
            <input type="email" name = "email" required>
            <br>
            <br>
            <input type="submit" value="Invia">
        </form>
        <a href="./index.php">torna alla home</a>
    </div>
</body>
</html>