<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once("./inizializzazione_sessione.php");
           
        if(!$_SESSION["isLogged"] || !$_SESSION["isAdmin"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
    ?>
    <div>
        <form action="./unban_email.php" method="post">
        <label><b>Digita la email da ripristinare</b></label>
            <br>
            <br>
            <label>Email</label>
            <br>
            <input type="email" name = "email" required>
            
            <?php if(isset($_GET['err']) && $_GET['err'] == 404): ?>
                <label><b>!!! Email non trovata, ritenta !!!</b></label>
            <?php elseif(isset($_GET['err']) && $_GET['err'] == 500): ?>
                <label><b>!!! Si è verificato un problema, ritenta !!!</b></label>
            <?php endif; ?>

            <?php if(isset($_SESSION['emails'])):?>
                <?php $emails = $_SESSION['emails'];?>
                <table>
                    <th>EMAIL</th>
                    <?php for($i = 0; $i < count($emails); $i++):?>
                        <tr>
                            <td><?= $emails[$i]['Email']?></td>
                        </tr>
                    <?php endfor;?>
                </table>
                
                <?php unset($_SESSION['emails']);?>
            <?php endif;?>


            <br>
            <br>
            <input type="submit" value="Invia">
        </form>
        <a href="./index.php">torna alla home</a>
        <a href="./lista_email_bannate.php">lista delle email bannate</a>
    </div>
</body>
</html>