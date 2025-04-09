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
            $query = "SELECT * FROM Pacchetti"; 
    ?>
    <?php if(!isset($_SESSION['carte_pacchetto'])): ?>
        <div>
            <?php foreach ($connection->query($query) as $row):?>
                <form action="apertura_pacchetto.php" method="post">
                    <img src="<?=$row['Immagine']?>" alt="" class = "packs">
                    <br>
                    <input type="submit" value="Apri pacchetto!">
                    <input type="hidden" name="id_pacchetto" value = "<?=$row['Id']?>">
                </form>
            <?php endforeach;?>
        </div>
    <?php else: ?>
        <div>
            <?php $carte = $_SESSION['carte_pacchetto'] ?>
            <?php for($i = 0; $i < count($carte); $i++):?>
                <img src="<?=$carte[$i]['Immagine']?>" alt="" class = "cards">
            <?php endfor;?>
        </div>
        <?php unset($_SESSION['carte_pacchetto']); ?>
    <?php endif; ?>
</body>
</html>
