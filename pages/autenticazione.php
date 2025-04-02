<?php
    require_once("./connessione.php");
    session_start();
    require_once("./inizializzazione_sessione.php");
        
    if($_SESSION["isLogged"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    if(!isset($_POST["username"]) || !isset($_POST["password"]))
        header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");

    $username = $_POST["username"];
    $password = $_POST["password"];
    $isAdmin = isset($_POST["admin"]);
    var_dump($isAdmin);
    $password = hash("sha256", $password);

    if ($isAdmin)
        $query = "SELECT Username FROM Utenti WHERE Username = :username AND Password :password AND IsAdmin > 0";
    else
        $query = "SELECT Username FROM Utenti WHERE Username = :username AND Password :password AND IsAdmin = 0";
        
        $result = $connection->prepare($query);
        $result->bindValue(":username", $username);
        $result->bindValue(":password", $password);
        $result->execute();
    
        if(count($result->fetchAll(PDO::FETCH_ASSOC)) == 1){
            if ($isAdmin) {
                $_SESSION['isLogged'] = true;
                $_SESSION['isAdmin'] = true;
            }
        }
    
?>