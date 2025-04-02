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
