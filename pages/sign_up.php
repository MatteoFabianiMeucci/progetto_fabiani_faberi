<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
        require_once("./inizializzazione_sessione.php");
           
        if($_SESSION["isLogged"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/");
    ?>

<nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">GCC pokemon pocket</a>
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                <img src="../images/layout/offcanvas_logo.png" alt="Menu Icon" style="width: 24px; height: 24px;">
            </button>
        </div>
    </nav>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <?php if(!$_SESSION["isLogged"]):?>
                    <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="./sign_up.php">Sign Up</a></li>
                <?php else:?>
                    <li class="nav-item"><a class="nav-link" href="./profilo.php">Profilo</a></li>
                    <li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>
                    <br>
                    <?php if(!$_SESSION["isAdmin"]):?>
                        <li class="nav-item"><a class="nav-link" href="./pacchetti.php">Pacchetti</a></li>
                        <li class="nav-item"><a class="nav-link" href="./carte.php">Carte</a></li>
                        <li class="nav-item"><a class="nav-link" href="./scegli_carte.php">Lotte</a></li>
                        <li class="nav-item"><a class="nav-link" href="./storico_lotte.php">Storico lotte</a></li>
                    <?php else:?>
                        <li class="nav-item"><a class="nav-link" href="form_delete_user.php">Elimina un utente</a></li>
                        <li class="nav-item"><a class="nav-link" href="./form_unban_email.php">Ripristina una email</a></li>
                    <?php endif;?>
                <?php endif;?>
            </ul>
        </div>
    </div>

    <div class="container my-5">
        <form action="./inserimento_utente.php" method="post" class="p-4 border rounded shadow-sm bg-light">
            <?php if(isset($_GET['err']) && $_GET['err'] == 403): ?>
                <div class="alert alert-danger" role="alert">
                    Username già utilizzato
                </div>
            <?php elseif (isset($_GET['err']) && $_GET['err'] == 401): ?>
                <div class="alert alert-warning" role="alert">
                    La mail è sottoposta ad un ban
                </div>
            <?php endif; ?>

            <h4 class="mb-4">Inserisci i dati dell'account da creare</h4>
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Invia</button>
        </form>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>