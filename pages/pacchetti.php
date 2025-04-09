<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Document</title>
</head>
<body>
    <?php
        require_once("./connessione.php");
        require_once("./inizializzazione_sessione.php");
        if(!$_SESSION["isLogged"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    ?>
    <div>
        <form action="" method="post">
        <?php $query = "SELECT * FROM Pacchetti"; ?>
        <?php foreach ($connection->query($query) as $row):?>
            <img src="<?=$row['Immagine']?>" alt="">
            <br>
            <input type="submit" value="Apri pacchetto!">
        <?php endforeach;?>
            
        </form>
    </div>
</body>
</html>