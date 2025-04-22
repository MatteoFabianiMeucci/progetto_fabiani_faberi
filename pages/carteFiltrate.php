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
    require_once("inizializzazione_sessione.php");
            require_once("./connessione.php");
            if(!$_SESSION["isLogged"]){
               header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
            }
        $conditions = [];
        $params = [];

        // Aggiunta filtri solo se settati
        if (!empty($_POST['nome'])) {
            $conditions[] = "nome = :nome";
            $params[':nome'] = $_POST['nome'];
        }

        if (!empty($_POST['tipo'])) {
            $conditions[] = "tipo = :tipo";
            $params[':tipo'] = $_POST['tipo'];
        }

        if (!empty($_POST['debolezza'])) {
            $conditions[] = "debolezza = :debolezza";
            $params[':debolezza'] = $_POST['debolezza'];
        }

        if (!empty($_POST['pacchetto'])) {
            $conditions[] = "pacchetto = :pacchetto";
            $params[':pacchetto'] = $_POST['pacchetto'];
        }

        // Query base
        $query = "SELECT * FROM carte";

        // Aggiunta condizioni se presenti
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $connection->prepare($query);
        $result->execute($params);
    ?>
    <?php
        foreach($result->fetchAll(PDO::FETCH_ASSOC) as $row):?>
            <img class="cards" src=<?=$row['Immagine']?>> 
    <?php endforeach;?>
        
</body>
</html>