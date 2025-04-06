<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
    if (!isset($_POST["username"]) || !$_SESSION["isLogged"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    $username = $_POST["username"];

    $query = "SELECT * FROM Utenti WHERE Username = :username";
    $result = $connection->prepare($query);
    $result->bindValue(":username", $username);
    $result->execute();
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) == 0){
        $query = "UPDATE Utenti SET Username = :username WHERE Id = :id";
        $result = $connection->prepare($query);
        $result->bindValue(":username", $username);
        $result->bindValue(":id", $_SESSION["id"]);
        if ($result->execute()){
            $_SESSION["username"] = $username;
            header("Location: http://localhost/progetto_fabiani_faberi/pages/profilo.php");
        }
        else{
            header("Location: http://localhost/progetto_fabiani_faberi/pages/form_new_username.php", false,500);
        }
    }else{
        header("Location: http://localhost/progetto_fabiani_faberi/pages/form_new_username.php?err=403");
    }

    
    
    
?>