<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <?php
        require_once("./connessione.php");
        require_once("./inizializzazione_sessione.php");
    ?>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">GCC pokemon pocket</a>
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                <img src="../images/layout/offcanvas_logo.png" alt="Menu Icon" style="width: 24px; height: 24px;">
            </button>
        </div>
    </nav>

    <?php if(!$_SESSION["isLogged"]): ?>
        
    <?php endif; ?>

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
    
        <?php if($_SESSION["isLogged"]): ?>
            <div class="alert alert-success text-center" role="alert">
                <b>Benvenuto, <?=$_SESSION["username"]?>!</b>
            </div>
            <?php else:?>
                <div class="alert alert-danger text-center" role="alert">
                    Non sei loggato. Effettua il login per accedere a tutte le funzionalità.
                    <br>
                    Clicca sulla pokeball in alto a destra per accedere al menu.
                </div>
        <?php endif; ?>
    <div class = "tutorial container">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <div class="sezione">
                    <h2>Introduzione</h2>
                    <p>Benvenuto nel nostro fantastico mondo di carte e avventure! Qui puoi:</p>
                    <ul>
                        <li>Collezionare carte uniche e straordinarie.</li>
                        <li>Partecipare a lotte epiche.</li>
                        <li>Personalizzare il tuo profilo e monitorare i tuoi progressi.</li>
                    </ul>
                    <p>Preparati a immergerti in un'esperienza incredibile!</p>
                </div>
            </div>
            <div class="col-md-4">
                <img src="../images/cards/45.webp" class="displayed_cards img-fluid" alt="Carta esempio">
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <div class="sezione">
                    <h2>1. Come ottenere le carte</h2>
                    <p>Collezionare carte è semplice e divertente:</p>
                    <ol>
                        <li>Visita la sezione <a href="./pacchetti.php">Pacchetti</a>.</li>
                        <li>Apri un pacchetto e inizia a collezionare carte, il primo te lo regaliamo noi.</li>
                        <li>Guarda la tua collezione crescere nella pagina delle <a href="./carte.php">carte</a>!</li>
                    </ol>
                    <p>Ogni nuova carta e' un passo in più verso il collezionarle tutte!</p>
                </div>
            </div>
            <div class="col-md-4">
                <img src="../images/cards/47.webp" class="displayed_cards img-fluid" alt="Carta esempio">
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <div class="sezione">
                    <h2>2. Come Fare le Lotte</h2>
                    <p>Le lotte sono il cuore dell'azione! Ecco come iniziare:</p>
                    <ol>
                        <li>Vai nella sezione <a href="./seleziona_carte.php">Lotte</a>.</li>
                        <li>Scegli una lotta dalla lista, seleziona le tue carte e... battaglia!</li>
                        <li>Usa strategia e abilità per vincere e ottenere ricompense.</li>
                    </ol>
                    <p>Ogni battaglia è un'esperienza unica. Completa tutte le lotte e guadagna esperienza per salire di livello e pokedollari per aprire nuovi pacchetti!</p>
                </div>
            </div>
            <div class="col-md-4">
                <img src="../images/cards/44.webp" class="displayed_cards img-fluid" alt="Carta esempio">
            </div>
        </div>
        <div class="sezione">
            <h2>Domande Frequenti (FAQ)</h2>
            <ul>
                <li><b>Come posso cambiare il mio username?</b> Vai sul tuo <a href="./profilo.php">profilo</a> e clicca sul tasto "edit" accanto al tuo username.</li>
                <li><b>Dove vedo le mie statistiche?</b> Nella pagina del <a href="./profilo.php">profilo</a> puoi vedere i tuoi pokedollari e il tuo livello.</li>
                <li><b>Come si naviga il sito?</b> Clicca sulla pokeball in alto a destra e visita le varie pagine, per tornare a quella principale basta cliccare sulla scritta "GCC pokemon pocket" in alto a sinistra.</li>
            </ul>
        </div>
    </div>
    <!--DA AGGIUNGERE: CARDS (pacchetti, carte, lotte)-->

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>