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
    <div>
        <label>Filtra per:</label>
        <?php
            require_once("inizializzazione_sessione.php");
            require_once("./connessione.php");
            $username = $_SESSION['username'];
                $query = "describe carte";
                $result = $connection->prepare($query);
                $result->execute();
                $columns = $result->fetchAll(PDO::FETCH_ASSOC);
                echo "<form method=\"post\"  action=\"carte.php\">";
                echo "<select name=\"\">
                    <option name=\"NoFiltro\">Nessun Filtro</option>";
                foreach($columns as $col){
                    echo "<option name=\"" . $col['Field'] . "\">" . $col['Field'] . "</option>";
                }
                echo "</select>
                      <input type=\"submit\">
                      </form>";

            $query = "SELECT * FROM carte /*JOIN carte_possedute ON carte.Id = carte_possedute.Id_carta JOIN utenti ON carte_possedute.id_utente = utenti.Id WHERE utenti.username = '$username'*/";
            ?><?php
            foreach($connection->query($query) as $row):?>
                <img class="cards" src=<?=$row['Immagine']?>> 
            

            <?php endforeach;?>

    


    </div>
</body>
</html>