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
           
        if(!$_SESSION["isLogged"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    ?>
    <div>
        <form action="./update_username.php" method="post">
        <label><b>Digita il nuovo username</b></label>
            <br>
            <br>
            <label>Username</label>
            <br>
            <input type="text" name = "username" required>

            <?php if(isset($_GET['err']) && $_GET['err'] == 403): ?>
                <label><b>!!! Username gia' utilizzato, ritenta !!!</b></label>
            <?php endif; ?>

            <br>
            <br>
            <input type="submit" value="Invia">
        </form>
        <a href="./index.php">torna alla home</a>
    </div>
</body>
</html>