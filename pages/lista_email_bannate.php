<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
        
    if(!$_SESSION["isLogged"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    }elseif(!$_SESSION["isAdmin"]){
        header("Location: http://localhost/progetto_fabiani_faberi/pages/?err=user");
    }else{
        $query = "SELECT * FROM Email_Bannate";
        if($result = $connection->query($query)){
            $result = $result->fetchAll();
            if(count($result) == 0){
                $temp = [];
                $msg = ["Email" => "Non ci sono email bannate"];
                $temp[] = $msg;
                $_SESSION['emails'] = $temp;
            }else{
                $_SESSION['emails'] = $result;
                var_dump($_SESSION['emails']);
            }

            header("Location: http://localhost/progetto_fabiani_faberi/pages/form_unban_email.php");
        }else{
            header("Location: http://localhost/progetto_fabiani_faberi/pages/form_unban_email.php?err=500");
        }
    }
?>