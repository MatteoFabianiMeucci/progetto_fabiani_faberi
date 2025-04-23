<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
        
    if(!$_SESSION["isLogged"] || !$_SESSION["isAdmin"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    elseif(!isset($_POST["email"]))
        header("Location: http://localhost/progetto_fabiani_faberi/pages/form_unban_email.php");
    else{
        $email = $_POST["email"];

        $query = "SELECT * FROM Email_Bannate WHERE Email = :email";
        $result = $connection->prepare($query);
        $result->bindValue(":email", $email);

        if($result->execute()){//ricerca della email (la query viene eseguita)
            $result = $result->fetchAll(PDO::FETCH_ASSOC);

            if(count($result) == 1){//la mail è stata trovata
                $query = "DELETE FROM Email_Bannate WHERE Email = :email";
                $result = $connection->prepare($query);
                $result->bindValue(":email", $email);
                
                if($result->execute()){//ripristino della email(la query viene eseguita)
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/");
                }else{//la query di ripristino della email non viene eseguita(errore 500)
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/form_unban_email.php?err=500");
                }

            } else{//la email non è stata trovata(errore 404)
                header("Location: http://localhost/progetto_fabiani_faberi/pages/form_unban_email.php?err=404");
            }

        }else{//la query di ricerca non viene eseguita(errore 500)
            header("Location: http://localhost/progetto_fabiani_faberi/pages/form_unban_email.php?err=500");
        }
    }
?>