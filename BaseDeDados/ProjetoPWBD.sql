DROP DATABASE IF EXISTS CentroInspecoes;
CREATE DATABASE CentroInspecoes;
USE CentroInspecoes;

CREATE TABLE TipoUtilizador (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32) NOT NULL
);

CREATE TABLE Utilizador (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(128),
    username VARCHAR(16) NOT NULL UNIQUE,
    email VARCHAR(128) UNIQUE,
    password VARCHAR(64),
    telemovel INT,
    telefone INT,
    dataCriacao DATETIME DEFAULT NOW() NOT NULL,
    isActive BOOLEAN DEFAULT FALSE NOT NULL,
    isDeleted BOOLEAN DEFAULT FALSE NOT NULL,
    idTipo INT,
    CONSTRAINT TB_Utilizador_TipoUtilizador_FK FOREIGN KEY (idTipo) REFERENCES TipoUtilizador(id)
);

CREATE TABLE CategoriaVeiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32) NOT NULL,
    duracao INT NOT NULL /* em minutos */
);

CREATE TABLE LinhaInspecao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(64),
    numero INT,
    idCategoria INT NOT NULL,
    CONSTRAINT TB_LinhaInspecao_CategoriaVeiculo_FK FOREIGN KEY (idCategoria) REFERENCES CategoriaVeiculo(id)
);

CREATE TABLE Inspecao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    horaInicio DATETIME NOT NULL,
    horaFim DATETIME NOT NULL,
    idCliente INT NOT NULL,
    idInspetor INT,
    idLinha INT NOT NULL,
    CONSTRAINT TB_Inspecao_Utilizador_Cliente_FK FOREIGN KEY (idCliente) REFERENCES Utilizador(id),
    CONSTRAINT TB_Inspecao_Utilizador_Inspetor_FK FOREIGN KEY (idInspetor) REFERENCES Utilizador(id),
    CONSTRAINT TB_Inspecao_LinhaInspecao_FK FOREIGN KEY (idLinha) REFERENCES LinhaInspecao(id)
);

INSERT INTO TipoUtilizador (nome) VALUES
    ('Administrador'), ('Inspector'), ('Cliente');

INSERT INTO Utilizador (nome, username, email, password, telemovel, telefone, isActive, idTipo) VALUES
    ('José Rodrigues', 'admin', 'admin@mail.com', '$2y$12$OgKQmortu0reACW6sMmwz.nbCSPztT/SUWe399O48YKkWQSoV/j5u', 912123168, NULL, TRUE, 1),
    ('Rodrigo Rafael', 'inspector', 'inspector@mail.com', '$2y$12$aWR7iVWNKAp12DQhSavGpOH9305vIUcH3NXyUlj8hMaTCX/r7uhX6', 925102312, NULL, TRUE, 2),
    ('Ricardo Pereira', 'cliente', 'cliente@mail.com', '$2y$12$5kqtya37Wf1ecQuDZybkSuxOaU.OxKb198L2wOH4ji8XFCrBZty3.', 912323123, NULL, TRUE, 3);

INSERT INTO CategoriaVeiculo (nome, duracao) VALUES
    ('Ligeiro de passageiros', 30), ('Motociclo', 30), ('Pesado de mercadorias', 60);

INSERT INTO LinhaInspecao (nome, idCategoria) VALUES
    ('AutoExp', 1), ('AutoFpz', 1), ('Moto', 2), ('Cami', 3);