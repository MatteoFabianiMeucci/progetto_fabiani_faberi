    <?php
        require_once("./connessione.php");
        require_once("./inizializzazione_sessione.php");
           
        if($_SESSION["isLogged"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
        if(!isset($_POST["username"]) || !isset($_POST["password"]))
            header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");

        $username = $_POST["username"];
        $password = $_POST["password"];
        $password = hash("sha256", $password);

        $query = "SELECT Username FROM Utenti WHERE Username = :username";
        $result = $connection->prepare($query);
        $result->bindValue(":username", $username);
        $result->execute();
        $usernames = $result->fetchAll(PDO::FETCH_ASSOC);
        if (count($usernames) == 0) {
            $query = "INSERT INTO Utenti (Username, Password, IsAdmin) VALUES (:username, :password, 0)";
            $result = $connection->prepare($query);
            $result->bindValue(":username", $username);
            $result->bindValue(":password", $password);
            $result->execute();
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
        }else
            header("Location: http://localhost/progetto_fabiani_faberi/pages/sign_up.php");
    ?>