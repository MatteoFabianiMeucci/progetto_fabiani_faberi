<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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

        $query = "SELECT Username FROM Utenti WHERE Username = :username";
        $result = $connection->prepare($query);
        $result->bindValue(":username", $username);
        $result->query();
        $usernames = $result->fetchAll(PDO::FETCH_ASSOC);
        if (count($usernames) == 0) {
            $query = "INSERT INTO Utenti (Username, Password, IsAdmin) VALUES (:username, :password)";
        }

    ?>
</body>
</html>