<?php
    if(count($_SESSION) == 0){
        $_SESSION["isLogged"] = false;
        $_SESSION["id"] = -1;
    }
?>