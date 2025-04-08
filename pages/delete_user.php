<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
        
    if(!$_SESSION["isLogged"] || !$_SESSION["isAdmin"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    elseif(!isset($_POST["username"]))
        header("Location: http://localhost/progetto_fabiani_faberi/pages/form_delete_user.php");
    else{
        $username = $_POST["username"];

        $query = "SELECT Id FROM Utenti WHERE Username = :username";
        $result = $connection->prepare($query);
        $result->bindValue(":username", $username);
        if($result->execute()){//ricerca dell'utente (la query viene eseguita)
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
            if(count($result) == 1){//l'utente è stato trovato
                $id = $result[0]["Id"];
                $query = "DELETE FROM Carte_Possedute WHERE Id_utente = :id";
                $result = $connection->prepare($query);
                $result->bindValue(":id", $id);
                
                if($result->execute()){//delete delle carte possedute dall'utente (la query viene eseguita)
                    $query = "DELETE FROM Lotte_Combattute WHERE Id_utente = :id";
                    $result = $connection->prepare($query);
                    $result->bindValue(":id", $id);
                    if($result->execute()){//delete delle lotte combattute dall'utente (la query viene eseguita)
                        $query = "DELETE FROM Utenti WHERE Id = :id";
                        $result = $connection->prepare($query);
                        $result->bindValue(":id", $id);
                        if($result->execute()){//delete dell'utente dal database (la query viene eseguita)
                            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
                        }else{//la query di delete dell'utente non viene eseguita(errore 500)
                            header("Location: http://localhost/progetto_fabiani_faberi/pages/form_delete_user.php?err=500");
                        }
                    }else{//la query di delete delle lotte combattute dall'utente non viene eseguita(errore 500)
                        header("Location: http://localhost/progetto_fabiani_faberi/pages/form_delete_user.php?err=500");
                    }
                }else{//la query di delete delle carte dell'utente non viene eseguita(errore 500)
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/form_delete_user.php?err=500");
                }
            } else{//l'utente non è stato trovato(errore 404)
                header("Location: http://localhost/progetto_fabiani_faberi/pages/form_delete_user.php?err=404");
            }
        }else{//la query di ricerca non viene eseguita(errore 500)
            header("Location: http://localhost/progetto_fabiani_faberi/pages/form_delete_user.php?err=500");
        }
    }
?>