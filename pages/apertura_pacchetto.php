<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
        
    if(!$_SESSION["isLogged"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    elseif(!isset($_POST["id_pacchetto"]))
        header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php");
    else{
        $id = $_POST["id_pacchetto"];
        $query = "SELECT Carte.Id Id, Carte.Immagine Immagine, Carte.Nome Nome FROM Pacchetti JOIN Carte ON (Carte.Pacchetto = Pacchetti.Id) WHERE Pacchetti.Id = :id";
        $result = $connection->prepare($query);
        $result->bindValue(":id", $id);
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        switch($id){
            case 1:
                $min_carta_ex = 0;
                $max_carta_ex = 15;
                $min_carta_comune = 16;
                $max_carta_comune = 42;
                break;
            case 2:
                $min_carta_ex = 0;
                $max_carta_ex = 13;
                $min_carta_comune = 14;
                $max_carta_comune = 22;
                break;
            case 3:
        
                break;
            default:
                header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php?err=404");
                break;
        }
        $carte = array();
        for ($i=0; $i < 5; $i++) {
            $carta_presente = false;
            $carta_comune = $result[rand($min_carta_comune, $max_carta_comune)];
            for( $j= 0; $j < count($carte); $j++) {
                if($carta_comune['Id'] == $carte[$j]['Id']){
                    $i--;
                    $carta_presente = true;
                    break;
                }
            }
            if(!$carta_presente){
                $carte[] = $carta_comune;
            }
        }
        $carta_ex = $result[rand($min_carta_ex,$max_carta_ex)];
        $carte[] = $carta_ex;
        $_SESSION['carte_pacchetto'] = $carte;
        header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php");  
    }
?>
