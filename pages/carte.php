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
        <?php
            require_once("inizializzazione_sessione.php");
            require_once("./connessione.php");
            if(!$_SESSION["isLogged"]){
               header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
            }
            $username = $_SESSION['username'];

            //filtro per tipo
            $query = "SELECT * FROM Tipo";
            $result = $connection->prepare($query);
            $result->execute();
            $columns = $result->fetchAll(PDO::FETCH_ASSOC);
            echo "<form method=\"post\"  action=\"carteFiltrate.php\"> 
                    <h1>Filtra per:</h1><br>
                    <label>Tipo </label>";
            foreach($columns as $col){
                
                echo "<input type=\"radio\" value=\"" . $col['Id'] . "\" name=\"tipo\"></input>";
                echo  "<label>" . $col['Tipo'] . "</label>";
            }

            //filtro per debolezza
            echo  "<br><label>Debolezza </label>";
            foreach($columns as $col){
                echo "<input type=\"radio\" value=\"" . $col['Id'] . "\" name=\"debolezza\"></input>";
                echo  "<label>" . $col['Tipo'] . "</label>";
            }
    
            //filtro per pacchetto
            $query = "SELECT * FROM Pacchetti";
            $result = $connection->prepare($query);
            $result->execute();
            $columns = $result->fetchAll(PDO::FETCH_ASSOC);
            
            echo  "<br><label>Pacchetto: </label>";
            foreach($columns as $col){
                echo "<input type=\"radio\" value=\"" . $col['Id'] . "\" name=\"pacchetto\"></input>";
                echo  "<label>" . $col['Nome'] . "</label>";
            }
            
            //filtro per nome e per attacco
            echo  "</select><br><label>Nome:</label><input name=\"nome\" type=\"text\">
                    <input type=\"submit\">
                    </form>";
                    
            //visualizzazione carte possedute dall'utente loggato
            $query = "SELECT * FROM carte JOIN carte_possedute ON carte.Id = carte_possedute.Id_carta JOIN utenti ON carte_possedute.id_utente = utenti.Id WHERE utenti.username = :username";
            $result = $connection->prepare($query);
            $result->bindValue(':username', $_SESSION['username']);
            $result->execute();
        ?>
        <?php
            foreach($result->fetchAll(PDO::FETCH_ASSOC) as $row):?>
                <img class="cards" src=<?=$row['Immagine']?>> 
        <?php endforeach;?>
    </div>
</body>
</html>