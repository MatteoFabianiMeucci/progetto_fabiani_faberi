<?php
    session_start();
    if(count($_SESSION) == 0){
        $_SESSION["isLogged"] = false;
        $_SESSION["isAdmin"] = false;
        $_SESSION["username"] = "";
        $_SESSION["id"] = -1;
    }
?>