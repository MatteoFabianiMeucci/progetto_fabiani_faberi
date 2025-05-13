<?php
    require_once("./connessione.php");
    require_once("./inizializzazione_sessione.php");
    //controlli di sicurezza
    if(!$_SESSION["isLogged"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    elseif($_SESSION["isAdmin"])
        header("Location: http://localhost/progetto_fabiani_faberi/pages/?err=admin");
    elseif(!isset($_POST["id_pacchetto"]))
        header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php");
    else{
        //quer per ottenere le carte del pacchetto selezionato
        $idPacchetto = $_POST["id_pacchetto"];
        $idUtente = $_SESSION['id'];
        $query = "SELECT Carte.Id Id, Carte.Immagine Immagine, Carte.Nome Nome FROM Pacchetti JOIN Carte ON (Carte.Pacchetto = Pacchetti.Id) WHERE Pacchetti.Id = :id";
        $result = $connection->prepare($query);
        $result->bindValue(":id", $idPacchetto);
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        //range per l'acquisizione delle carte in base alla rarità e alla posizione nel db
        switch($idPacchetto){
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
                $max_carta_comune = 42;
                break;
            case 3:
                $min_carta_ex = 0;
                $max_carta_ex = 25;
                $min_carta_comune = 26;
                $max_carta_comune = 57;
                break;
                
            default:
                header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php?err=404");
                break;
        }
        //creazione array delle carte trovate
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
        //inserimento pacchetto aperto nel db
        $data = date('Y-m-d H:i:s');
        $query = "INSERT INTO Pacchetti_Aperti(Id_utente, Id_pacchetto, Data) VALUES (:idUtente, :idPacchetto, :data)";
        $result = $connection->prepare($query);
        $result->bindValue(":idUtente", $idUtente);
        $result->bindValue(":idPacchetto", $idPacchetto);
        $result->bindValue(":data", $data);
        if($result->execute()){
            header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php");
        }else{
            header("Location: http://localhost/progetto_fabiani_faberi/pages/pacchetti.php?err=500");
        }
    }
?>
