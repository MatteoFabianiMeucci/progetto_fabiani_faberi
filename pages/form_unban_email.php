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
           
        if(!$_SESSION["isLogged"] || !$_SESSION["isAdmin"])
            header("Location: http://localhost/progetto_fabiani_faberi/pages/login.php?err=403");
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
                        <li class="nav-item"><a class="nav-link" href="./scegli_mazzo.php">Lotte</a></li>
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
        <form action="./unban_email.php" method="post" class="p-4 border rounded shadow-sm bg-light">
            <h4 class="mb-4 text-center">Ripristina una email</h4>
            
            <div class="mb-3">
                <label for="email" class="form-label"><b>Digita la email da ripristinare</b></label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <?php if(isset($_GET['err']) && $_GET['err'] == 404): ?>
                <div class="alert alert-danger" role="alert">
                    !!! Email non trovata, ritenta !!!
                </div>
            <?php elseif(isset($_GET['err']) && $_GET['err'] == 500): ?>
                <div class="alert alert-warning" role="alert">
                    !!! Si è verificato un problema, ritenta !!!
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['emails'])): ?>
                <?php $emails = $_SESSION['emails']; ?>
                <div class="mt-4">
                    <h5 class="text-center">Email Bannate</h5>
                    <table class="table table-bordered bg-white">
                        <thead>
                            <tr>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($emails as $email): ?>
                                <tr>
                                    <td><?= $email['Email'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php unset($_SESSION['emails']); ?>
            <?php else: ?>
                <div class="text-center my-3">
                    <a href="./lista_email_bannate.php" class="text-decoration-none">Lista delle email bannate</a>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary w-100">Invia</button>
        </form>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>