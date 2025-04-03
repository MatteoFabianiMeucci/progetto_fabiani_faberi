<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
        
    if($_SESSION["isLogged"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    if(!isset($_POST["username"]) || !isset($_POST["password"]))
        header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");

    $username = $_POST["username"];
    $password = $_POST["password"];
    $isAdmin = isset($_POST["admin"]);
    $password = hash("sha256", $password);

    if ($isAdmin)
        $query = "SELECT Id, Username FROM Utenti WHERE Username = :username AND Password = :password AND IsAdmin > 0";
    else
        $query = "SELECT Id, Username FROM Utenti WHERE Username = :username AND Password = :password AND IsAdmin = 0";
        
        $result = $connection->prepare($query);
        $result->bindValue(":username", $username);
        $result->bindValue(":password", $password);
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        ;
        
        if(count($result) == 1){
            $_SESSION['isLogged'] = true;
            $_SESSION['id'] = $result[0]["Id"];
            $_SESSION['isAdmin'] = $isAdmin;
            $_SESSION['username'] = $result[0]["Username"];
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
        } else{
            header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php");
        }
?>