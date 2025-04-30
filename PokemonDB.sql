CREATE DATABASE PokemonDB;
USE PokemonDB;

CREATE TABLE Utenti (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(30) NOT NULL,
    Password VARCHAR(64) NOT NULL,
    Email VARCHAR(264),
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
    Immagine VARCHAR(60),
    Costo INT
);

CREATE TABLE Carte (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(25) NOT NULL,
    PS INT NOT NULL,
    Tipo INT,
    Immagine VARCHAR(60),
    Debolezza INT,
    Pacchetto INT,
    Attacco INT,
    FOREIGN KEY (Tipo) REFERENCES Tipo(Id),
    FOREIGN KEY (Pacchetto) REFERENCES Pacchetti(Id),
    FOREIGN KEY (Attacco) REFERENCES Attacchi(Id),
    FOREIGN KEY (Debolezza) REFERENCES Tipo(Id)
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
    IsVinta BOOL,
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

CREATE TABLE Pacchetti_Aperti (
    Id_utente INT,
    Id_pacchetto INT,
    Data VARCHAR(19),
    PRIMARY KEY (Id_utente, Id_pacchetto, Data),
    FOREIGN KEY (Id_utente) REFERENCES Utenti(Id),
    FOREIGN KEY (Id_pacchetto) REFERENCES Pacchetti(Id)
);

CREATE TABLE Email_Bannate(
	Id INT PRIMARY KEY AUTO_INCREMENT,
    Email VARCHAR(264)
);

INSERT INTO Tipo(Tipo) VALUES
('Erba'),
('Fuoco'),
('Elettro'),
('Lotta'),
('Psico'),
('Oscurità'),
('Acqua');

INSERT INTO Pacchetti(Nome, Immagine, Costo) VALUES
('Ossidiana Infuocata', '../images/packs/01.jpg', 10),
('151', '../images/packs/02.jpg', 15) -- https://vivatcg.com/categoria-prodotto/carte-singole/carte-singole-scarlatto-e-violetto/carte-singole-151/?jsf=woocommerce-archive&pagenum=3
;

INSERT INTO Attacchi(Nome, Danno, Tipo) VALUES
('Freccia Implacabile', 130, 1), -- 1
('Assalto della Colonia', 80, 1),
('Fiamma della Vittoria', 220, 2),
('Ustioblocco', 160, 7),
('Furia Fulminante', 150, 3),
('Colposaetta', 60, 3),
('Luna Meravigliosa', 170, 5),
('Omaggio ai KO', 160, 5),
('Caduta Pressa', 100, 4),
('Gaiapressa', 230, 4), -- 10
('Oscurità Infuocata', 180, 2),
('Zanna del Segugio', 220, 6),
('Danza a Nove Code', 90, 2),
('Passafoglia', 20, 1),
('Fuggi Fuggi', 10, 1),
('Carica Avventata', 30, 1),
('Carica', 20, 1),
('Calorazione', 30, 2),
('Stordiraggio', 20, 2),
('Fuocospiro', 10, 2), -- 20
('Ventogelido', 100, 7),
('Avvitacoda', 10, 7),
('Balzoprova', 30, 7),
('Spruzzapioggia', 10, 7),
('Velocipalla', 20, 3),
('Minifulmine', 30, 3),
('Coinvolgimento', 30, 3),
('Scuoti e Scarica', 20, 3),
('Pesca Smaniosa', 30, 5),
('Rollazione', 20, 5), -- 30
('Immersione Rapida', 40, 5),
('Sgranocchio Birichino', 30, 5),
('Ciclone Notturno', 120, 6),
('Abbraccio', 30, 6),
('Zuccone Scavatore', 30, 4),
('Fossa', 50, 4),
('Rollazione', 30, 4),
('Piagnisteo', 10, 4),
('Tonfo', 30, 6),
('Tossifrusta Pericolosa', 150, 1), -- 40
('Vortice Esplodivo', 330, 2),
('Fiamme Riflesse', 80, 2),
('Duocannone', 140, 7),
('Zanne Minacciose', 150, 6),
('Mano DImensionale', 120, 5),
('Hacking del Genoma', 150, 5),
('Esplodiroccia', 180, 4),
('Ventogelato', 120, 7),
('Fulmine Multicolpo', 120, 3),
('Idrosquarcio', 90, 7), -- 50
('Parassiseme', 20, 1),
('Mangifoglia', 10, 1),
('Volo di Addio', 60, 1),
('Colemorso', 20, 1),
('Pallaspore', 20, 1),
('Soffiofuoco', 30, 2),
('Super Scottata', 20, 2),
('Tonfo', 30, 2),
('Girata Match', 90, 2),
('Capocciata', 20, 7), -- 60
('Attacco Rotante', 50, 7),
('Pistolacqua', 10, 7),
('Bolla', 10, 7),
('Pantanobomba', 80, 4),
('Colpo', 20, 4),
('Pugno', 30, 4),
('Noccapugno', 20, 4),
('Psicosparo', 20, 5),
('Bottintesta', 20, 5),
('Psicocolpo', 130, 5), -- 70
('Cozzata Zen', 30, 5),
('Pika Pugno', 50, 3),
('Fulmine Combattente', 90, 3),
('Pugnetto', 30, 3),
('Attacco Capriola', 10, 3),
('Gas Sospetto', 20, 6),
('Pressa Appiccicosa', 10, 6),
('Fangobomba', 180, 6),
('Morso', 10, 6); -- 79


INSERT INTO Carte(Nome, PS, Tipo, Immagine, Debolezza, Pacchetto, Attacco) VALUES
('Decidueye Ex', 320, 1, '../images/cards/01.webp', 2, 1, 1),
('Toedscruel Ex', 270, 1, '../images/cards/02.webp', 2, 1, 2),
('Victini Ex', 190, 2, '../images/cards/03.webp', 7, 1, 3),
('Eiscue Ex', 210, 2, '../images/cards/04.webp', 7, 1, 4),
('Tyranitar Ex', 340, 3, '../images/cards/05.png', 4, 1, 5),
('Pawmot Ex', 300, 3, '../images/cards/06.webp', 4, 1, 6),
('Clefable Ex', 260, 5, '../images/cards/07.webp', 6, 1, 7),
('Houndstone Ex', 260, 5, '../images/cards/08.webp', 6, 1, 8),
('Klawf Ex', 220, 4, '../images/cards/09.webp', 1, 1, 9),
('Koraidon Ex', 230, 4, '../images/cards/10.webp', 5, 1, 10),
('Charizard Ex', 330, 6, '../images/cards/11.webp', 1, 1, 11),
('Houndoom Ex', 270, 6, '../images/cards/12.webp', 1, 1, 12),
('Charizard-Ex', 330, 6, '../images/cards/13.webp', 1, 1, 11),
('Tyranitar-Ex', 340, 3, '../images/cards/14.webp', 4, 1, 5),
('Ninetales', 120, 2, '../images/cards/15.webp', 7, 1, 13),
('Gloom', 80, 1, '../images/cards/16.webp', 2, 1, 14),
('Oddish', 50, 1, '../images/cards/17.webp', 2, 1, 15),
('Bounsweet', 60, 1 , '../images/cards/18.webp', 2, 1, 16),
('Gloom', 80, 1, '../images/cards/19.webp', 2, 1, 14),
('Combee', 50, 1, '../images/cards/20.webp', 2, 1, 17),
('Charmander', 60, 2, '../images/cards/21.webp', 7, 1, 18),
('Vulpix', 60, 2, '../images/cards/22.webp', 7, 1, 19),
('Ninetales', 120, 2, '../images/cards/23.webp', 7, 1, 13),
('Litwick', 60, 2, '../images/cards/24.webp', 7, 1, 20),
('Lapras', 110, 7, '../images/cards/25.webp', 3, 1, 21),
('Tympole', 70, 7, '../images/cards/26.webp', 3, 1, 22),
('Froakie', 70, 7, '../images/cards/27.webp', 3, 1, 23),
('Wigglet', 60, 7, '../images/cards/28.webp', 3, 1, 24),
('Magnemite', 60, 3, '../images/cards/29.webp', 4, 1, 25),
('Tynamo', 40, 3, '../images/cards/30.webp', 4, 1, 26),
('Toxel', 70, 3, '../images/cards/31.webp', 4, 1, 27),
('Tadbulb', 60, 3, '../images/cards/32.webp', 4, 1, 28),
('Cleffa', 30, 5, '../images/cards/33.webp', 6, 1, 29),
('Togepi', 50, 5, '../images/cards/34.webp', 6, 1, 30),
('Togetic', 90, 5, '../images/cards/35.webp', 6, 1, 31),
('Mawile', 100, 6, '../images/cards/36.webp', 6, 1, 32),
('Darkrai', 130, 6, '../images/cards/37.webp', 1, 1, 33),
('Inkay', 60, 6, '../images/cards/38.webp', 1, 1, 34),
('Diglett', 50, 4, '../images/cards/39.webp', 1, 1, 35),
('Dugtrio', 90, 4, '../images/cards/40.webp', 1, 1, 36),
('Nosepass', 90, 4, '../images/cards/41.webp', 1, 1, 37),
('Bonsly', 30, 4, '../images/cards/42.webp', 1, 1, 38),
('Wooper', 70, 6, '../images/cards/43.webp', 4, 1, 39),

('Venusaur Ex', 340, 1, '../images/cards/44.webp', 2, 2, 40), -- inizio secondo pcchetto
('Charizard Ex', 330, 2, '../images/cards/45.webp', 7, 2, 41),
('Ninetales Ex', 260, 2, '../images/cards/46.webp', 7, 2, 42),
('Blastoise Ex', 330, 7, '../images/cards/47.webp', 3, 2, 43),
('Arbok Ex', 270, 6, '../images/cards/48.webp', 2, 2, 44),
('Alakazam Ex', 310, 5, '../images/cards/49.webp', 6, 2, 45),
('Mew Ex', 180, 5, '../images/cards/50.webp', 6, 2, 46),
('Golem Ex', 330, 4, '../images/cards/51.webp', 1, 2, 47),
('Jynx Ex', 200, 7, '../images/cards/52.webp', 3, 2, 48),
('Zapdos Ex', 200, 3, '../images/cards/53.webp', 3, 2, 49),
('Zapdos Ex', 200, 3, '../images/cards/54.webp', 3, 2, 49),
('Mew Ex', 180, 5, '../images/cards/55.webp', 6, 2, 46),
('Dragonair', 100, 7, '../images/cards/56.webp', 3, 2, 50),
('Venusaur Ex', 340, 1, '../images/cards/57.webp', 2, 2, 40),
('Bulbasaur', 70, 1, '../images/cards/58.webp', 2, 2, 51),
('Caterpie', 50, 1, '../images/cards/59.webp', 2, 2, 52),
('Butterfree', 130, 1, '../images/cards/60.webp', 2, 2, 53),
('Weedle', 50, 1, '../images/cards/61.webp', 2, 2, 54),
('Paras', 70, 1, '../images/cards/62.webp', 2, 2, 55),
('Charmander', 70, 2, '../images/cards/63.webp', 7, 2, 56),
('Vulpix', 70, 2, '../images/cards/64.webp', 7, 2, 57),
('Ponyta', 70, 2, '../images/cards/65.webp', 7, 2, 58),
('Rapidash', 100, 2, '../images/cards/66.webp', 7, 2, 59),
('Squirtle', 60, 7, '../images/cards/67.webp', 3, 2, 60),
('Wartortle', 100, 7, '../images/cards/68.webp', 3, 2, 61),
('Psyduck', 70, 7, '../images/cards/69.webp', 3, 2, 62),
('Poliwag', 60, 7, '../images/cards/70.webp', 3, 2, 63),
('Dugtrio', 90, 4, '../images/cards/71.webp', 1, 2, 64),
('Mankey', 60, 4, '../images/cards/72.webp', 5, 2, 65),
('Machop', 70, 4, '../images/cards/73.webp', 5, 2, 66),
('Geodude', 80, 4, '../images/cards/74.webp', 1, 2, 67),
('Abra', 50, 5, '../images/cards/75.webp', 6, 2, 68),
('Slowpoke', 80, 5, '../images/cards/76.webp', 6, 2, 69),
('Mewtwo', 130, 5, '../images/cards/77.webp', 6, 2, 70),
('Drowzee', 80, 5, '../images/cards/78.webp', 6, 2, 71),
('Pikachu', 60, 3, '../images/cards/79.webp', 4, 2, 72),
('Jolteon', 110, 3, '../images/cards/80.webp', 4, 2, 73),
('Electabuzz', 90, 3, '../images/cards/81.webp', 4, 2, 74),
('Voltorb', 60, 3, '../images/cards/82.webp', 4, 2, 75),
('Koffing', 60, 6, '../images/cards/83.webp', 4, 2, 76),
('Grimer', 80, 6, '../images/cards/84.webp', 4, 2, 77),
('Muk', 150, 6, '../images/cards/85.webp', 4, 2, 78),
('Zubat', 40, 6, '../images/cards/86.webp', 3, 2, 79);



