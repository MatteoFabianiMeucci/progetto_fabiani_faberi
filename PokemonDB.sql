CREATE DATABASE PokemonDB;
USE PokemonDB;

CREATE TABLE Utenti (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(30) NOT NULL,
    Password VARCHAR(64) NOT NULL,
    Email VARCHAR(264),
    Immagine VARCHAR(300),
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
('Acqua'),
('Drago');

INSERT INTO Pacchetti(Nome, Immagine, Costo) VALUES
('Ossidiana Infuocata', '../images/packs/01.jpg', 10),
('151', '../images/packs/02.jpg', 15), -- https://vivatcg.com/categoria-prodotto/carte-singole/carte-singole-scarlatto-e-violetto/carte-singole-151/?jsf=woocommerce-archive&pagenum=3
('Tempesta Argentata', '../images/packs/03.jpeg', 20);

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
('Colemorso', 30, 1),
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
('Morso', 10, 6), -- 79
('Dynascoppio', 180, 8), -- rayquaza in poi 80
('Gigapolverizzazione', 220, 8), 
('Onda Soave', 60, 7),
('Fiammata Bianca', 200, 2),
('Aerotuffo', 130, 8),
('Fame Immprovvisa', 90, 5),
('Magicolpo', 110, 5),
('Dragartigli', 120, 8),
('Vento Distruttivo', 90, 7),
('Tifone Aereo', 190, 6),
('Gigatifone', 240, 6),
('Solarraggio', 120, 1),  -- 90
('Astro Avvolgente', 190, 1),
('Astro Neveargento', 70, 7),
('Blocco Tentacolare', 110, 7),
('Elettromuro', 100, 3),
('Dynafolgore Tonante', 220, 3),
('Serramascella', 100, 5),
('Simbolo di Vittoria', 90, 5),
('Dardopietra', 90, 4),
('Torbaspalla', 220, 4), -- 100
('Dragolaser', 130, 8), -- 100
('Fiammabaleno', 100, 2), 
('Perforare', 50, 1),
('Morso', 50, 1),
('Colpo Aroma', 90, 1),
('Salta su', 30, 2),
('Corteo Fiammeggiante', 60, 2),
('Sgretolenergia', 100, 2),
('Colpo Implacabile', 160, 2),
('Gelo Selvaggio', 70, 7),
('Schizzi Onda', 60, 7), --110
('Onda Soave', 60, 7),
('Granbocca', 130, 7),
('Lamposfera', 120, 3),
('Schiaffetto', 20, 3),
('Supervolt', 160, 3),
('Shock Statico', 40, 3),
('Signore della Mente', 60, 5),
('Tirar Giù', 30, 5),
('Azione Cavernosa', 120, 4),
('Acrobazia', 30, 4), -- 120 
('Caduta Fossili', 30, 4),
('Trappola0', 10, 4),
('Beccata', 10, 6),
('Ali Spietate', 120, 6),
('Pugno Rotante', 30, 6),
('Tuffomontante', 120, 6),
('Settima Eco', 70, 8),
('Attacco Veloce', 70, 8),
('Aliante', 30, 8),
('Schianto', 30, 8); -- 130

INSERT INTO Carte(Nome, PS, Tipo, Immagine, Debolezza, Pacchetto, Attacco) VALUES
('Decidueye Ex', 320, 1, '../images/cards/01.webp', 2, 1, 1),
('Toedscruel Ex', 270, 1, '../images/cards/02.webp', 2, 1, 2),
('Victini Ex', 190, 2, '../images/cards/03.webp', 7, 1, 3),
('Eiscue Ex', 210, 2, '../images/cards/04.webp', 7, 1, 4),
('Tyranitar Ex', 340, 3, '../images/cards/05.webp', 4, 1, 5),
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
('Mawile', 100, 5, '../images/cards/36.webp', 6, 1, 32),
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
('Dragonair', 100, 8, '../images/cards/56.webp', 3, 2, 50),
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
('Zubat', 40, 6, '../images/cards/86.webp', 3, 2, 79),

('Rayquaza Vmax', 320, 8, '../images/cards/87.webp', 6, 3, 80),  -- terzo pacchetto
('Duraludon Vmax', 330, 8, '../images/cards/88.webp', 6, 3, 81),
('Milotic', 130, 7, '../images/cards/89.webp', 3, 3, 82),
('Reshiram V', 220, 2, '../images/cards/90.webp', 7, 3, 83),
('Lugia V', 220, 8, '../images/cards/91.webp', 3, 3, 84),
('Lugia V', 220, 8, '../images/cards/92.webp', 3, 3, 84),
('Mawile Vastro', 260, 5, '../images/cards/93.webp', 8, 3, 85),
('Gardevoir', 150, 5, '../images/cards/94.webp', 8, 3, 86),
('Druddigon', 120, 8, '../images/cards/95.webp', 6, 3, 87),
('Altaria', 110, 7, '../images/cards/96.webp', 3, 3, 88),
('Corviknight V', 210, 6, '../images/cards/97.webp', 2, 3, 89),
('Corviknight Vmax', 210, 6, '../images/cards/98.webp', 2, 3, 90),
('Serperior V', 210, 1, '../images/cards/99.webp', 2, 3, 91),
('Serperior Vmax', 270, 1, '../images/cards/100.webp', 2, 3, 92),
('Reshiram V', 220, 2, '../images/cards/101.webp', 7, 3, 83),
('Vulpix Vastro', 240, 7, '../images/cards/102.webp', 3, 3, 93),
('Omastar V', 190, 7, '../images/cards/103.webp', 3, 3, 94),
('Regieleki V', 200, 3, '../images/cards/104.webp', 4, 3, 95),
('Regieleki Vmax', 310, 3, '../images/cards/105.webp', 4, 3, 96),
('Mawile V', 200, 5, '../images/cards/106.webp', 6, 3, 97),
('Unown V', 180, 5, '../images/cards/107.webp', 6, 3, 98),
('Arcanine V', 230, 4, '../images/cards/108.webp', 1, 3, 99),
('Ursaluna V', 230, 4, '../images/cards/109.webp', 1, 3, 100),
('Lugia V', 220, 8, '../images/cards/110.webp', 3, 3, 84),
('Regidrago V', 220, 8, '../images/cards/111.webp', 6, 3, 101),
('Ho-Oh V', 230, 2, '../images/cards/112.webp', 3, 3, 102),
('Spinarak', 60, 1, '../images/cards/113.webp', 2, 3, 103), -- normal
('Ariados', 90, 1, '../images/cards/114.webp', 2, 3, 54),
('Durant', 90, 1, '../images/cards/115.webp', 2, 3, 104),
('Tsareena Lucente', 140, 1, '../images/cards/116.webp', 2, 3, 105),
('Vulpix', 70, 2, '../images/cards/117.webp', 7, 3, 106),
('Braixen', 90, 2, '../images/cards/118.webp', 7, 3, 107),
('Delphox', 150, 2, '../images/cards/119.webp', 7, 3, 108),
('Talonflame', 140, 2, '../images/cards/120.webp', 7, 3, 19),
('Articuno', 110, 7, '../images/cards/121.webp', 3, 3, 110),
('Wailmer', 110, 7, '../images/cards/122.webp', 3, 3, 111),
('Milotic', 130, 7, '../images/cards/123.webp', 3, 3, 112),
('Glalie', 130, 7, '../images/cards/124.webp', 8, 3, 113),
('Raichu', 120, 3, '../images/cards/125.webp', 4, 3, 114),
('Chinchou', 60, 3, '../images/cards/126.webp', 4, 3, 115),
('Lanturn', 120, 3, '../images/cards/127.webp', 4, 3, 116),
('Emolga', 70, 3, '../images/cards/128.webp', 4, 3, 117),
('Alakazam Lucente', 130, 5, '../images/cards/129.webp', 6, 3, 118),
('Meditite', 60, 5, '../images/cards/130.webp', 6, 3, 68),
('Chimecho', 70, 5, '../images/cards/131.webp', 6, 3, 119),
('Slurpuff', 120, 5, '../images/cards/132.webp', 6, 3, 85),
('Terrakion', 130, 4, '../images/cards/133.webp', 1, 3, 120),
('Hawlucha', 80, 4, '../images/cards/134.webp', 3, 3, 121),
('Anorith', 90, 4, '../images/cards/135.webp', 1, 3, 122),
('Sandygast', 80, 4, '../images/cards/136.webp', 1, 3, 123),
('Murkrow', 60, 6, '../images/cards/137.webp', 3, 3, 124),
('Honchkrow', 120, 6, '../images/cards/138.webp', 3, 3, 125),
('Croagunk', 80, 6, '../images/cards/139.webp', 4, 3, 126),
('Toxicroak', 120, 6, '../images/cards/140.webp', 4, 3, 127),
('Noivern', 110, 8, '../images/cards/141.webp', 7, 3, 128),
('Zygarde', 90, 8, '../images/cards/142.webp', 7, 3, 129),
('Noibat', 60, 8, '../images/cards/143.webp', 4, 3, 130),
('Dratini', 70, 8, '../images/cards/144.webp', 4, 3, 131);

CREATE DATABASE PokeDB;
USE PokeDB;

CREATE TABLE Utenti (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(30) NOT NULL,
    Password VARCHAR(64) NOT NULL,
    Email VARCHAR(264),
    Immagine VARCHAR(300),
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
('Acqua'),
('Drago');

INSERT INTO Pacchetti(Nome, Immagine, Costo) VALUES
('Ossidiana Infuocata', '../images/packs/01.jpg', 10),
('151', '../images/packs/02.jpg', 15), -- https://vivatcg.com/categoria-prodotto/carte-singole/carte-singole-scarlatto-e-violetto/carte-singole-151/?jsf=woocommerce-archive&pagenum=3
('Tempesta Argentata', '../images/packs/03.jpeg', 20);

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
('Colemorso', 30, 1),
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
('Morso', 10, 6), -- 79
('Dynascoppio', 180, 8), -- rayquaza in poi 80
('Gigapolverizzazione', 220, 8), 
('Onda Soave', 60, 7),
('Fiammata Bianca', 200, 2),
('Aerotuffo', 130, 8),
('Fame Immprovvisa', 90, 5),
('Magicolpo', 110, 5),
('Dragartigli', 120, 8),
('Vento Distruttivo', 90, 7),
('Tifone Aereo', 190, 6),
('Gigatifone', 240, 6),
('Solarraggio', 120, 1),  -- 90
('Astro Avvolgente', 190, 1),
('Astro Neveargento', 70, 7),
('Blocco Tentacolare', 110, 7),
('Elettromuro', 100, 3),
('Dynafolgore Tonante', 220, 3),
('Serramascella', 100, 5),
('Simbolo di Vittoria', 90, 5),
('Dardopietra', 90, 4),
('Torbaspalla', 220, 4), -- 100
('Dragolaser', 130, 8), -- 100
('Fiammabaleno', 100, 2), 
('Perforare', 50, 1),
('Morso', 50, 1),
('Colpo Aroma', 90, 1),
('Salta su', 30, 2),
('Corteo Fiammeggiante', 60, 2),
('Sgretolenergia', 100, 2),
('Colpo Implacabile', 160, 2),
('Gelo Selvaggio', 70, 7),
('Schizzi Onda', 60, 7), -- 110
('Onda Soave', 60, 7),
('Granbocca', 130, 7),
('Lamposfera', 120, 3),
('Schiaffetto', 20, 3),
('Supervolt', 160, 3),
('Shock Statico', 40, 3),
('Signore della Mente', 60, 5),
('Tirar Giù', 30, 5),
('Azione Cavernosa', 120, 4),
('Acrobazia', 30, 4), -- 120 
('Caduta Fossili', 30, 4),
('Trappola0', 10, 4),
('Beccata', 10, 6),
('Ali Spietate', 120, 6),
('Pugno Rotante', 30, 6),
('Tuffomontante', 120, 6),
('Settima Eco', 70, 8),
('Attacco Veloce', 70, 8),
('Aliante', 30, 8),
('Schianto', 30, 8); -- 130

INSERT INTO Carte(Nome, PS, Tipo, Immagine, Debolezza, Pacchetto, Attacco) VALUES
('Decidueye Ex', 320, 1, '../images/cards/01.webp', 2, 1, 1),
('Toedscruel Ex', 270, 1, '../images/cards/02.webp', 2, 1, 2),
('Victini Ex', 190, 2, '../images/cards/03.webp', 7, 1, 3),
('Eiscue Ex', 210, 2, '../images/cards/04.webp', 7, 1, 4),
('Tyranitar Ex', 340, 3, '../images/cards/05.webp', 4, 1, 5),
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
('Dragonair', 100, 8, '../images/cards/56.webp', 3, 2, 50),
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
('Zubat', 40, 6, '../images/cards/86.webp', 3, 2, 79),
('Rayquaza Vmax', 320, 8, '../images/cards/87.webp', 6, 3, 80),  -- terzo pacchetto
('Duraludon Vmax', 330, 8, '../images/cards/88.webp', 6, 3, 81),
('Milotic', 130, 7, '../images/cards/89.webp', 3, 3, 82),
('Reshiram V', 220, 2, '../images/cards/90.webp', 7, 3, 83),
('Lugia V', 220, 8, '../images/cards/91.webp', 3, 3, 84),
('Lugia V', 220, 8, '../images/cards/92.webp', 3, 3, 84),
('Mawile Vastro', 260, 5, '../images/cards/93.webp', 8, 3, 85),
('Gardevoir', 150, 5, '../images/cards/94.webp', 8, 3, 86),
('Druddigon', 120, 8, '../images/cards/95.webp', 6, 3, 87),
('Altaria', 110, 7, '../images/cards/96.webp', 3, 3, 88),
('Corviknight V', 210, 6, '../images/cards/97.webp', 2, 3, 89),
('Corviknight Vmax', 210, 6, '../images/cards/98.webp', 2, 3, 90),
('Serperior V', 210, 1, '../images/cards/99.webp', 2, 3, 91),
('Serperior Vmax', 270, 1, '../images/cards/100.webp', 2, 3, 92),
('Reshiram V', 220, 2, '../images/cards/101.webp', 7, 3, 83),
('Vulpix Vastro', 240, 7, '../images/cards/102.webp', 3, 3, 93),
('Omastar V', 190, 7, '../images/cards/103.webp', 3, 3, 94),
('Regieleki V', 200, 3, '../images/cards/104.webp', 4, 3, 95),
('Regieleki Vmax', 310, 3, '../images/cards/105.webp', 4, 3, 96),
('Mawile V', 200, 5, '../images/cards/106.webp', 6, 3, 97),
('Unown V', 180, 5, '../images/cards/107.webp', 6, 3, 98),
('Arcanine V', 230, 4, '../images/cards/108.webp', 1, 3, 99),
('Ursaluna V', 230, 4, '../images/cards/109.webp', 1, 3, 100),
('Lugia V', 220, 8, '../images/cards/110.webp', 3, 3, 84),
('Regidrago V', 220, 8, '../images/cards/111.webp', 6, 3, 101),
('Ho-Oh V', 230, 2, '../images/cards/112.webp', 3, 3, 102),
('Spinarak', 60, 1, '../images/cards/113.webp', 2, 3, 103), -- normal
('Ariados', 90, 1, '../images/cards/114.webp', 2, 3, 54),
('Durant', 90, 1, '../images/cards/115.webp', 2, 3, 104),
('Tsareena Lucente', 140, 1, '../images/cards/116.webp', 2, 3, 105),
('Vulpix', 70, 2, '../images/cards/117.webp', 7, 3, 106),
('Braixen', 90, 2, '../images/cards/118.webp', 7, 3, 107),
('Delphox', 150, 2, '../images/cards/119.webp', 7, 3, 108),
('Talonflame', 140, 2, '../images/cards/120.webp', 7, 3, 19),
('Articuno', 110, 7, '../images/cards/121.webp', 3, 3, 110),
('Wailmer', 110, 7, '../images/cards/122.webp', 3, 3, 111),
('Milotic', 130, 7, '../images/cards/123.webp', 3, 3, 112),
('Glalie', 130, 7, '../images/cards/124.webp', 8, 3, 113),
('Raichu', 120, 3, '../images/cards/125.webp', 4, 3, 114),
('Chinchou', 60, 3, '../images/cards/126.webp', 4, 3, 115),
('Lanturn', 120, 3, '../images/cards/127.webp', 4, 3, 116),
('Emolga', 70, 3, '../images/cards/128.webp', 4, 3, 117),
('Alakazam Lucente', 130, 5, '../images/cards/129.webp', 6, 3, 118),
('Meditite', 60, 5, '../images/cards/130.webp', 6, 3, 68),
('Chimecho', 70, 5, '../images/cards/131.webp', 6, 3, 119),
('Slurpuff', 120, 5, '../images/cards/132.webp', 6, 3, 85),
('Terrakion', 130, 4, '../images/cards/133.webp', 1, 3, 120),
('Hawlucha', 80, 4, '../images/cards/134.webp', 3, 3, 121),
('Anorith', 90, 4, '../images/cards/135.webp', 1, 3, 122),
('Sandygast', 80, 4, '../images/cards/136.webp', 1, 3, 123),
('Murkrow', 60, 6, '../images/cards/137.webp', 3, 3, 124),
('Honchkrow', 120, 6, '../images/cards/138.webp', 3, 3, 125),
('Croagunk', 80, 6, '../images/cards/139.webp', 4, 3, 126),
('Toxicroak', 120, 6, '../images/cards/140.webp', 4, 3, 127),
('Noivern', 110, 8, '../images/cards/141.webp', 7, 3, 128),
('Zygarde', 90, 8, '../images/cards/142.webp', 7, 3, 129),
('Noibat', 60, 8, '../images/cards/143.webp', 4, 3, 130),
('Dratini', 70, 8, '../images/cards/144.webp', 4, 3, 131);


INSERT INTO Lotte (Exp, Premio) VALUES
(50, 2),   -- 1
(50, 2),   -- 2
(75, 5),   -- 3
(75, 5),   -- 4
(100, 10),  -- 5
(100, 10),  -- 6
(100, 10),  -- 7

(75, 5),   -- 8
(75, 5),   -- 9
(75, 5),   -- 10
(100, 10),   -- 11
(100, 10),  -- 12
(125, 13),  -- 13
(125, 13),  -- 14

(90, 8),   -- 15
(90, 8),   -- 16
(90, 8),   -- 17
(110, 12),   -- 18
(110, 12),  -- 19
(125, 13),  -- 20
(125, 13);  -- 21


INSERT INTO Carte_Lotte(Id_carta, Id_lotta) VALUES 

-- Lotta 1 (Erba) - solo normali
(113, 1), (18, 1), (16, 1), (17, 1), (20, 1),

-- Lotta 2 (Fuoco) - solo normali 
(66, 2), (22, 2), (23, 2), (21, 2), (24, 2),

-- Lotta 3 (Elettro) - 1 EX 
(52, 3), (26, 3), (27, 3), (25, 3), (28, 3),

-- Lotta 4 (acqua) - 1 EX 
(8, 4), (36, 4), (34, 4), (35, 4), (33, 4), 

-- Lotta 5 (psico) - 2 EX 
(7, 5), (8, 5), (33, 5), (34, 5), (35, 5),

-- Lotta 6 (Buio) - 2 EX 
(12, 6), (13, 6), (43, 6), (37, 6), (38, 6), 

-- Lotta 7 (lotta) - 2 EX 
(9, 7), (10, 7), (39, 7), (40, 7), (41, 7),

-- Lotta 8 (Erba) - 1 EX
(57, 8), (59, 8), (60, 8), (61, 8), (62, 8),

-- Lotta 9 (oscurita) - 1 EX
(48, 9), (83, 9), (84, 9), (85, 9), (86, 9),

-- Lotta 10 (lotta) - 1 EX
(51, 10), (71, 10), (72, 10), (73, 10), (74, 10),

-- Lotta 11 (Psico) - 2 EX
(49, 11), (50, 11), (76, 11), (77, 11), (78, 11), -- Alakazam Ex

-- Lotta 12 (Elettro) - 2 EX
(54, 12), (53, 12), (80, 12), (81, 12), (82, 12), 

-- Lotta 13 (acqua) - 2 EX
(47, 13), (52, 13), (68, 13), (69, 13), (70, 13),

-- Lotta 14 (Fuoco) - 2 EX
(45, 14), (46, 14), (63, 14), (64, 14), (65, 14),

-- Lotta 15 (psico) - 1 EX
(93, 15), (129, 15), (130, 15), (131, 15), (132, 15),

-- Lotta 16 (lotta) - solo normali
(108, 16), (133, 16), (134, 16), (135, 16), (136, 16),

-- Lotta 17 (elettro) - 1 EX
(105, 17), (125, 17), (126, 17), (127, 17), (128, 17), 

-- Lotta 18 (fuoco) - 1 EX
(112, 18), (101, 18), (117, 18), (118, 18), (119, 18), 

-- Lotta 19 (erba) - 2 EX
(99, 19), (100, 19), (116, 19), (114, 19), (115, 19),

-- Lotta 20 (Buio) - 2 EX
(97, 20), (98, 20), (138, 20), (139, 20), (140, 20),

-- Lotta 21 (drago) - 2 EX
(87, 21), (92, 21), (141, 21), (142, 21), (143, 21); 

