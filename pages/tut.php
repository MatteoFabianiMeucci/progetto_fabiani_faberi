<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial - Come Usare il Sito</title>
    <style>
        body {
            font-family: 'Comic Sans MS', sans-serif;
            background-color: #fdf6e3;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ffcc00;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            position: relative;
        }

        header img {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 50px;
            height: 50px;
        }

        main {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: relative;
        }

        section {
            margin-bottom: 30px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #ff6600;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 10px 0;
            background: #ffcc00;
            color: #fff;
        }

        .card-image {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 100px;
            height: auto;
            opacity: 0.8;
        }

        .background-image {
            position: absolute;
            opacity: 0.1;
            z-index: -1;
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        <img src="path/to/logo.png" alt="Logo del Sito">
        <h1>Benvenuto nel Sito delle Carte e delle Lotte!</h1>
    </header>
    <main>
        <img src="path/to/background.jpg" class="background-image" alt="Sfondo Allegro">

        <section id="introduzione">
            <h2>Introduzione</h2>
            <p>Benvenuto nel nostro fantastico mondo di carte e avventure! Qui puoi:</p>
            <ul>
                <li>Collezionare carte uniche e straordinarie.</li>
                <li>Partecipare a lotte epiche contro altri giocatori.</li>
                <li>Personalizzare il tuo profilo e monitorare i tuoi progressi.</li>
            </ul>
            <p>Preparati a immergerti in un'esperienza colorata e divertente!</p>
            <img src="path/to/card1.jpg" class="card-image" alt="Carta esempio">
        </section>

        <section id="prendere-carte">
            <h2>1. Come Prendere le Carte</h2>
            <p>Raccogliere carte è semplice e divertente:</p>
            <ol>
                <li>Visita la sezione <a href="/carte">Carte</a>.</li>
                <li>Scegli la tua preferita e clicca su "Prendi Carta".</li>
                <li>Guarda la tua collezione crescere nella pagina del profilo!</li>
            </ol>
            <p>Ogni carta ha le sue caratteristiche uniche. Scopri nuovi poteri e abilità!</p>
            <img src="path/to/card2.jpg" class="card-image" alt="Carta esempio">
        </section>

        <section id="fare-lotte">
            <h2>2. Come Fare le Lotte</h2>
            <p>Le lotte sono il cuore dell'azione! Ecco come iniziare:</p>
            <ol>
                <li>Vai nella sezione <a href="/lotte">Lotte</a>.</li>
                <li>Scegli un avversario dalla lista, seleziona le tue carte e... battaglia!</li>
                <li>Usa strategia e abilità per vincere e ottenere ricompense.</li>
            </ol>
            <p>Ogni battaglia è un'esperienza unica. Sconfiggi i tuoi avversari e scala la classifica!</p>
            <img src="path/to/card3.jpg" class="card-image" alt="Carta esempio">
        </section>

        <section id="faq">
            <h2>Domande Frequenti</h2>
            <ul>
                <li><strong>Come scambio carte?</strong> Usa la sezione "Scambi" per negoziare con altri giocatori.</li>
                <li><strong>Dove vedo le mie statistiche?</strong> Nella pagina del profilo puoi vedere il tuo punteggio e i tuoi progressi.</li>
                <li><strong>Come funziona il sistema a turni?</strong> Ogni giocatore ha un turno per attaccare o difendersi usando le carte.</li>
            </ul>
            <img src="path/to/card4.jpg" class="card-image" alt="Carta esempio">
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Il Sito delle Carte e delle Lotte. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>