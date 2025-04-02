CREATE DATABASE PokemonDB;
USE PokemonDB;

CREATE TABLE Utenti (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(30) NOT NULL,
    Password VARCHAR(30) NOT NULL,
    IsAdmin BOOL
);

CREATE TABLE Tipo (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tipo VARCHAR(15) NOT NULL
);

CREATE TABLE Attacchi (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(25) NOT NULL,
    Danno INT NOT NULL,
    Tipo INT,
    FOREIGN KEY (Tipo) REFERENCES Tipo(Id)
);

CREATE TABLE Pacchetti (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(100) NOT NULL,
    Immagine VARCHAR(60)
);

CREATE TABLE Carte (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(25) NOT NULL,
    PS INT NOT NULL,
    Tipo INT,
    Immagine VARCHAR(60),
    Debolezza VARCHAR(15),
    Pacchetto INT,
    Attacco INT,
    FOREIGN KEY (Tipo) REFERENCES Tipo(Id),
    FOREIGN KEY (Pacchetto) REFERENCES Pacchetti(Id),
    FOREIGN KEY (Attacco) REFERENCES Attacchi(Id)
);

CREATE TABLE Carte_Possedute (
    Id_utente INT,
    Id_carta INT,
    PRIMARY KEY (Id_utente, Id_carta),
    FOREIGN KEY (Id_utente) REFERENCES Utenti(Id),
    FOREIGN KEY (Id_carta) REFERENCES Carte(Id)
);

CREATE TABLE Lotte (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Exp INT NOT NULL,
    Premio INT NOT NULL
);

CREATE TABLE Lotte_Combattute (
    Id_utente INT,
    Id_lotta INT,
    Data Varchar(19),
    Esito VARCHAR(5),
    PRIMARY KEY (Id_utente, Id_lotta, Data),
    FOREIGN KEY (Id_utente) REFERENCES Utenti(Id),
    FOREIGN KEY (Id_lotta) REFERENCES Lotte(Id)
);

CREATE TABLE Carte_Lotte (
    Id_carta INT,
    Id_lotta INT,
    PRIMARY KEY (Id_carta, Id_lotta),
    FOREIGN KEY (Id_carta) REFERENCES Carte(Id),
    FOREIGN KEY (Id_lotta) REFERENCES Lotte(Id)
);


INSERT INTO Carte(Nome, PS, Tipo, Immagine, Debolezza, Pacchetto, Attacco) VALUES
(Decidueye Ex, 320, 1, ../images/cards/001, 2, 1, 1),
(Toedscruel Ex, 270, 1, ../images/cards/02, 2, 1, 2),
(Victini Ex, 190, 2, ../images/cards/03, 7, 1, 3),
(Eiscue Ex, 210, 2, ../images/cards/04, 7, 1, 4),
(Tyranitar Ex, 340, 3, ../images/cards/05, 4, 1, 5),
(Pawmot Ex, 300, 3, ../images/cards/06, 4, 1, 6),
(Clefable Ex, 260, 5, ../images/cards/07, 6, 1, 7),
(Houndstone Ex, 260, 5, ../images/cards/08, 6, 1, 8),
(Klawf Ex, 220, 4, ../images/cards/09, 1, 1, 9),
(Koraidon Ex, 230, 4, ../images/cards/10, 5, 1, 10),
(Charizard Ex, 330, 6, ../images/cards/11, 1, 1, 11),
(Houndoom Ex, 270, 6, ../images/cards/12, 1, 1, 12),


;

INSERT INTO Attacchi(Nome, Danno, Tipo) VALUES
(Freccia Implacabile, 130, 1),
(Assalto della Colonia, 80, 1),
(Fiamma della Vittoria, 220, 2),
(Ustioblocco, 160, 7),
(Furia Fulminante, 150, 3),
(Colposaetta, 60, 3),
(Luna Meravigliosa, 170, 5),
(Omaggio ai KO, 160, 5),
(Caduta Pressa, 100, 4),
(Galapressa, 230, 4),
(OScurità Infuocata, 180, 2),
(Zanna del Segugio, 220, 6),


;

INSERT INTO Pacchetti(Nome, Immagine) VALUES
(Ossidiana Infuocata, ../images/packs/01),
;

INSERT INTO Tipo(Tipo) VALUES
(Erba),
(Fuoco),
(Elettro),
(Lotta),
(Psico),
(Oscurità),
(Acqua);
