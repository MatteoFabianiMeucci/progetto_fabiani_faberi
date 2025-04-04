CREATE DATABASE PokemonDB;
USE PokemonDB;

CREATE TABLE Utenti (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(30) NOT NULL,
    Password VARCHAR(64) NOT NULL,
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
('Decidueye Ex', 320, 1, '../images/cards/01', 2, 1, 1),
('Toedscruel Ex', 270, 1, '../images/cards/02', 2, 1, 2),
('Victini Ex', 190, 2, '../images/cards/03', 7, 1, 3),
('Eiscue Ex', 210, 2, '../images/cards/04', 7, 1, 4),
('Tyranitar Ex', 340, 3, '../images/cards/05', 4, 1, 5),
('Pawmot Ex', 300, 3, '../images/cards/06', 4, 1, 6),
('Clefable Ex', 260, 5, '../images/cards/07', 6, 1, 7),
('Houndstone Ex', 260, 5, '../images/cards/08', 6, 1, 8),
('Klawf Ex', 220, 4, '../images/cards/09', 1, 1, 9),
('Koraidon Ex', 230, 4, '../images/cards/10', 5, 1, 10),
('Charizard Ex', 330, 6, '../images/cards/11', 1, 1, 11),
('Houndoom Ex', 270, 6, '../images/cards/12', 1, 1, 12),
('Oddish', 50, 1, '../images/cards/13', 2, 1, 13),
('Bounsweet', 60, 1 , '../images/cards/14', 2, 1, 13),
('Gloom', 90, 1, '../images/cards/15', 2, 1, 14),
('Combee', 50, 1, '../images/cards/16', 2, 1, 15),
('Charmander', 60, 2, '../images/cards/17', 1, 1, 16),
('Vulpix', 60, 2, '../images/cards/18', 1, 1, 17),
('Ninetales', 100, 2, '../images/cards/19', 1, 1, 18),
('Litwick', 60, 2, '../images/cards/20', 1, 1, 19)
('Lapras', 200, 7, '../images/cards/21', 2, 1, 20),
('Tympole', 60, 7, '../images/cards/22', 2, 1, 21),
('Froakie', 60, 7, '../images/cards/23', 2, 1, 22),
('Wigglet', 60, 7, '../images/cards/24', 2, 1, 23),
('Magnemite', 50, 3, '../images/cards/25', 4, 1, 24),
('Tynamo', 40, 3, '../images/cards/26', 4, 1, 25),
('Toxel', 60, 3, '../images/cards/27', 4, 1, 26),
('Tadbulb', 60, 3, '../images/cards/28', 4, 1, 27),
('Cleffa', 50, 5, '../images/cards/29', 4, 1, 28),
('Togepi', 50, 5, '../images/cards/30', 4, 1, 29),
('Togetic', 100, 5, '../images/cards/31', 4, 1, 30),
('Mawile', 130, 6, '../images/cards/32', 4, 1, 31),
('Darkrai', 280, 6, '../images/cards/33', 5, 1, 32),
('Inkay', 60, 6, '../images/cards/34', 4, 1, 33),
('Diglett', 60, 4, '../images/cards/35', 2, 1, 34),
('Dugtrio', 100, 4, '../images/cards/36', 2, 1, 35),
('Nosepass', 70, 4, '../images/cards/37', 2, 1, 29),
('Bonsly', 60, 4, '../images/cards/38', 2, 1, 36),
('Wooper', 60, 6, '../images/cards/39', 2, 1, 37);

INSERT INTO Attacchi(Nome, Danno, Tipo) VALUES
('Freccia Implacabile', 130, 1),
('Assalto della Colonia', 80, 1),
('Fiamma della Vittoria', 220, 2),
('Ustioblocco', 160, 7),
('Furia Fulminante', 150, 3),
('Colposaetta', 60, 3),
('Luna Meravigliosa', 170, 5),
('Omaggio ai KO', 160, 5),
('Caduta Pressa', 100, 4),
('Galapressa', 230, 4),
('Oscurità Infuocata', 180, 2),
('Zanna del Segugio', 220, 6),
('Fuggi Fuggi', 10, 1),
('Passofoglia', 20, 1),
('Carica', 20, 1),
('Calorazione', 30, 2),
('Stordiraggio', 20, 2),
('Danza a Nove Code', 90, 2),
('Fuocospiro', 10, 2),
('Ventogelido', 100, 7),
('Avvitacoda', 10, 7),
('Balzoprova', 30, 7),
('Spruzzapioggia', 10, 7),
('Velocipalla', 20, 3),
('Minifulmine', 30, 3),
('Coinvolgimento', 30, 3),
('Scoppiotuono', 40, 3),
('Pesca Smaniosa', 30, 5),
('Rollazione', 20, 5),
('Immersione Rapida', 40, 5),
('Sgranocchio Birichino', 30, 5),
('Ciclone Notturno', 120, 6),
('Abbraccio', 30, 6),
('Zuccone Scavatore', 30, 4),
('Fossa', 50, 4),
('Piagnisteo', 10, 4),
('Sputaveleno', 20, 6);

INSERT INTO Pacchetti(Nome, Immagine) VALUES
('Ossidiana Infuocata', ../images/packs/01),
('151', ../images/packs/02), -- https://vivatcg.com/categoria-prodotto/carte-singole/carte-singole-scarlatto-e-violetto/carte-singole-151/?jsf=woocommerce-archive&pagenum=3
;

INSERT INTO Tipo(Tipo) VALUES
(Erba),
(Fuoco),
(Elettro),
(Lotta),
(Psico),
(Oscurità),
(Acqua);
