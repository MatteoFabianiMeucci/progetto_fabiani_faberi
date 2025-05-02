<?php
require_once("./connessione.php");
require_once("./inizializzazione_sessione.php");

if (!$_SESSION['isLogged']) {
    header("Location: ./login.php?err=403");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $targetDir = "../images/user_icons/";

    $fileName = basename($_FILES['profile_pic']['name']);
    $targetFile = $targetDir . $_SESSION['id'] . "_" . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Controllo se il file e' un'immagine
    $check = getimagesize($_FILES['profile_pic']['tmp_name']);
    if ($check === false) {
        header("Location: ./profilo.php?err=invalid_image");
        exit;
    }

    // Si accetta solo alcuni formati di immagine
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        header("Location: ./profilo.php?err=invalid_format");
        exit;
    }

    // Inserimento della nuova immagine nella cartella apposita
    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
        // La vecchia immagine profilo viene cancellata se esiste e non e' quella di default
        if (isset($_SESSION['profile_pic']) && $_SESSION['profile_pic'] !== "../images/user_icons/default.jpg") {
            if (file_exists($_SESSION['profile_pic'])) {
                unlink($_SESSION['profile_pic']);
            }
        }

        $_SESSION['profile_pic'] = $targetFile;

        $query = "UPDATE Utenti SET Immagine = :immagine WHERE Id = :id";
        $result = $connection->prepare($query);
        $result->bindValue(":immagine", $targetFile);
        $result->bindValue(":id", $_SESSION['id']);
        $_SESSION['immagine'] = $targetFile;
        if ($result->execute()) {
            header("Location: ./profilo.php?success=uploaded");
        } else {
            header("Location: ./profilo.php?err=update_failed");
        }
    } else {
        header("Location: ./profilo.php?err=upload_failed");
    }
} else {
    header("Location: ./profilo.php");
}
?>
