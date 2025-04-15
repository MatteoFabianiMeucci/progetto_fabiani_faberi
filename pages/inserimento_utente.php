    <?php
        require_once("./connessione.php");
        require_once("./inizializzazione_sessione.php");
           
        if($_SESSION["isLogged"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
        elseif(!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["email"]))
            header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
        else{
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email = $_POST["email"];
            $password = hash("sha256", $password);

            $query = "SELECT * FROM Email_Bannate WHERE Email = :email";
            $result = $connection->prepare($query);
            $result->bindValue(":email", $email);
            if($result->execute()){
                $emails = $result->fetchAll(PDO::FETCH_ASSOC);
                if(count($emails) == 0){
                    $query = "SELECT Username FROM Utenti WHERE Username = :username";
                    $result = $connection->prepare($query);
                    $result->bindValue(":username", $username);
                    if($result->execute()){
                        $usernames = $result->fetchAll(PDO::FETCH_ASSOC);
                        if (count($usernames) == 0) {
                            $query = "INSERT INTO Utenti (Username, Password, Email, IsAdmin) VALUES (:username, :password, :email, 0)";
                            $result = $connection->prepare($query);
                            $result->bindValue(":username", $username);
                            $result->bindValue(":password", $password);
                            $result->bindValue(":email", $email);
                            if($result->execute()){
                                header("Location: http://localhost/progetto_fabiani_faberi/pages/");
                            }else{
                                header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php?err=500");
                            }
                        }else{
                            header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php?err=403");
                        }
                    }else{
                        header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php?err=500");
                    }
                }else{
                    header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php?err=401");
                }
            }else{
                header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php?err=500");
            }
        }
    ?>