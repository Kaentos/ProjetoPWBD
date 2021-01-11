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
    dataEdicao DATETIME DEFAULT NOW() NOT NULL,
    isActive BOOLEAN DEFAULT FALSE NOT NULL,
    isDeleted BOOLEAN DEFAULT FALSE NOT NULL,
    idTipo INT NOT NULL,
    CONSTRAINT TB_Utilizador_TipoUtilizador_FK FOREIGN KEY (idTipo) REFERENCES TipoUtilizador(id)
);

CREATE TABLE CategoriaVeiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32) NOT NULL,
    duracao INT NOT NULL /* em minutos */
);

CREATE TABLE Veiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    matricula VARCHAR(6) NOT NULL UNIQUE,
    ano INT NOT NULL,
    marca TEXT NOT NULL,
    idCategoria INT NOT NULL,
    CONSTRAINT TB_Veiculo_CategoriaVeiculo_FK FOREIGN KEY (idCategoria) REFERENCES CategoriaVeiculo(id)
);

CREATE TABLE Veiculo_Utilizador (
    idVeiculo INT,
    idUtilizador INT,
    PRIMARY KEY (idVeiculo, idUtilizador),
    CONSTRAINT TB_VeiculoUtilizador_Veiculo_FK FOREIGN KEY (idVeiculo) REFERENCES Veiculo(id),
    CONSTRAINT TB_VeiculoUtilizador_Utilizador_FK FOREIGN KEY (idUtilizador) REFERENCES Utilizador(id)
);

CREATE TABLE LinhaInspecao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(64),
    idCategoria INT NOT NULL,
    CONSTRAINT TB_LinhaInspecao_CategoriaVeiculo_FK FOREIGN KEY (idCategoria) REFERENCES CategoriaVeiculo(id)
);

CREATE TABLE LinhaInspecao_Utilizador (
    idLinha INT,
    idUtilizador INT PRIMARY KEY,
    CONSTRAINT TB_LinhaInspecaUtilizador_LinhaInspecao_FK FOREIGN KEY (idLinha) REFERENCES LinhaInspecao(id),
    CONSTRAINT TB_LinhaInspecaUtilizador_Utilizador_FK FOREIGN KEY (idUtilizador) REFERENCES Utilizador(id)
);

CREATE TABLE Inspecao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    horaInicio DATETIME NOT NULL,
    horaFim DATETIME NOT NULL,
    idCliente INT NOT NULL,
    idVeiculo INT NOT NULL,
    idLinha INT NOT NULL,
    isDoing BOOLEAN DEFAULT FALSE NOT NULL,  
    isCompleted BOOLEAN DEFAULT FALSE NOT NULL,
    CONSTRAINT TB_Inspecao_Utilizador_Cliente_FK FOREIGN KEY (idCliente) REFERENCES Utilizador(id),
    CONSTRAINT TB_Inspecao_Veiculo_FK FOREIGN KEY (idVeiculo) REFERENCES Veiculo(id),
    CONSTRAINT TB_Inspecao_LinhaInspecao_FK FOREIGN KEY (idLinha) REFERENCES LinhaInspecao(id)
);

INSERT INTO TipoUtilizador VALUES
    (1, 'Administrador'), (2, 'Inspector'), (3, 'Cliente'), (0, "Apagado");

INSERT INTO Utilizador (nome, username, email, password, telemovel, telefone, isActive, idTipo) VALUES
    ('Jose Rodrigues', 'admin', 'admin@mail.com', '$2y$12$OgKQmortu0reACW6sMmwz.nbCSPztT/SUWe399O48YKkWQSoV/j5u', 912123168, NULL, TRUE, 1),
    ('Rodrigo Rafael', 'inspector', 'inspector@mail.com', '$2y$12$aWR7iVWNKAp12DQhSavGpOH9305vIUcH3NXyUlj8hMaTCX/r7uhX6', 925102312, NULL, TRUE, 2),
    ('Ricardo Pereira', 'cliente', 'cliente@mail.com', '$2y$12$5kqtya37Wf1ecQuDZybkSuxOaU.OxKb198L2wOH4ji8XFCrBZty3.', 912323123, NULL, TRUE, 3),
    ('Miguel Rodrigo', 'inspector2', 'inspector2@mail.com', '$2y$12$aWR7iVWNKAp12DQhSavGpOH9305vIUcH3NXyUlj8hMaTCX/r7uhX6', 91929451, NULL, TRUE, 2), 
    ('Andre Correia', 'inspector3', 'inspector3@mail.com', '$2y$12$aWR7iVWNKAp12DQhSavGpOH9305vIUcH3NXyUlj8hMaTCX/r7uhX6', 919293321, NULL, TRUE, 2), 
    ('Miguel Rodrigo', 'inspector4', 'inspector4@mail.com', '$2y$12$aWR7iVWNKAp12DQhSavGpOH9305vIUcH3NXyUlj8hMaTCX/r7uhX6', 919292323, NULL, TRUE, 2);

INSERT INTO CategoriaVeiculo VALUES
    (1, 'Ligeiro de passageiros', 30), (2, 'Motociclo', 30), (3, 'Pesado de mercadorias', 60);

INSERT INTO LinhaInspecao (nome, idCategoria) VALUES
    ('AutoExp', 1), ('AutoFpz', 1), ('Moto', 2), ('Cami', 3);

INSERT INTO LinhaInspecao_Utilizador VALUES (1, 2), (2,4), (3,5), (4,6);

INSERT INTO Veiculo (matricula, ano, marca, idCategoria) VALUES ('A3B2SD', 2000, 'Honda Civic', 1);

INSERT INTO Veiculo_Utilizador VALUES (1, 3);

INSERT INTO Inspecao (horaInicio, horaFim, idCliente, idVeiculo, idLinha)
VALUES ('2021-01-07 18:00:00', '2021-01-07 19:00:00', 3, 1, 1), ('2021-01-11 18:00:00', '2021-01-11 19:00:00', 3, 1, 1);