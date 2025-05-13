<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
        
    if($_SESSION["isLogged"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/?err=logged");
    elseif(!isset($_POST["username"]) || !isset($_POST["password"]))
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    else{
        $username = $_POST["username"];
        $password = $_POST["password"];
        $isAdmin = isset($_POST["admin"]);
        $password = hash("sha256", $password);

        //query in base al tipo di accesso (da amministratore o da utente normale)
        if ($isAdmin)
            $query = "SELECT Id, Username, Immagine FROM Utenti WHERE Username = :username AND Password = :password AND IsAdmin > 0";
        else
            $query = "SELECT Id, Username, Immagine FROM Utenti WHERE Username = :username AND Password = :password AND IsAdmin = 0";
            
            $result = $connection->prepare($query);
            $result->bindValue(":username", $username);
            $result->bindValue(":password", $password);
            if( $result->execute()){
                $result = $result->fetchAll(PDO::FETCH_ASSOC);
                //tutti i dati dell'utente vengono salvati in sessione
                if(count($result) == 1){
                    $_SESSION['isLogged'] = true;
                    $_SESSION['id'] = $result[0]["Id"];
                    $_SESSION['isAdmin'] = $isAdmin;
                    $_SESSION['username'] = $result[0]["Username"];
                    $_SESSION['immagine'] = $result[0]["Immagine"];
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/");
                } else{
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=404");
                }
            }else{
                header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=500");
            }

    }
?>