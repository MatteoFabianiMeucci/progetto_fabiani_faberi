<?php
    require_once("inizializzazione_sessione.php");
    $_SESSION["isLogged"] = false;
    $_SESSION["isAdmin"] = false;
    $_SESSION["id"] = -1;
    header("Location: http://localhost/progetto_fabiani_faberi/pages/");
?>