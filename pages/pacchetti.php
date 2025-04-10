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
    <?php if(!isset($_SESSION['carte_pacchetto'])): ?>
        <div>
            <?php $query = "SELECT * FROM Pacchetti"; ?>
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
            <?php $carte = $_SESSION['carte_pacchetto']; ?>
            <h1>CARTE TROVATE</h1>
            <?php for($i = 0; $i < count($carte); $i++):?>
                <img src="<?=$carte[$i]['Immagine']?>" alt="" class = "cards">
            <?php endfor;?>
        </div>
        <?php
            for($i = 0; $i < count($carte); $i++){
                
                $id_carta = $carte[$i]['Id'];
                $query = "SELECT * FROM Carte_Possedute WHERE Id_utente = :id_utente AND Id_carta = :id_carta";
                $result = $connection->prepare($query);
                $result->bindValue(":id_carta", $id_carta);
                $result->bindValue(":id_utente", $_SESSION['id']);
                if($result->execute()){
                    $row = $result->fetchAll(PDO::FETCH_ASSOC);
                    if(count($row) == 0){
                        $query = "INSERT INTO Carte_Possedute(Id_utente, Id_carta) VALUES (:id_utente, :id_carta)";
                        $result = $connection->prepare($query);
                        $result->bindValue(":id_utente", $_SESSION['id']);
                        $result->bindValue(":id_carta", $id_carta);
                        $result->execute();
                    }else{
                        echo "<p>Possiedi gia' ".$carte[$i]["Nome"]."</p>";
                    }
                }else{
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php?err=500");
                }
            }
            unset($_SESSION['carte_pacchetto']);
        ?>
    <?php endif; ?>
</body>
</html>
