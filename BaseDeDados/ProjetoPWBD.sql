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
    email VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    /*morada VARCHAR(256),*/
    /*cc INT NOT NULL UNIQUE,
    dataNasc DATE NOT NULL,*/
    telemovel INT NOT NULL,
    telefone INT,
    dataCriacao DATETIME DEFAULT NOW() NOT NULL,
    isActive BOOLEAN DEFAULT FALSE NOT NULL,
    isDeleted BOOLEAN DEFAULT FALSE NOT NULL,
    idTipo INT NOT NULL,
    CONSTRAINT TB_Utilizador_TipoUtilizador_FK FOREIGN KEY (idTipo) REFERENCES TipoUtilizador(id)
    /* USELESS AF FAZER TRIGGERS
    CONSTRAINT TB_Utilizador_dataNasc_CHECK CHECK(YEAR(dataNasc) >= (YEAR(NOW()) - 100) AND YEAR(dataNasc) <= (YEAR(NOW()) - 18))
    CONSTRAINT TB_Utilizador_cc_CHECK CHECK(cc >= 10000000 AND cc <= 99999999),
    CONSTRAINT TB_Utilizador_telemovel_CHECK CHECK(cc >= 100000000 AND cc <= 999999999),
    CONSTRAINT TB_Utilizador_cc_CHECK CHECK(cc >= 100000000 AND cc <= 999999999)*/
);

CREATE TABLE CategoriaVeiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32) NOT NULL,
    duracao INT NOT NULL /* em minutos */
);

CREATE TABLE Veiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32) NOT NULL,
    descricao VARCHAR(256) NOT NULL,
    matricula VARCHAR(6) NOT NULL UNIQUE,
    idCategoria INT NOT NULL,
    CONSTRAINT TB_Veiculo_CategoriaVeiculo_FK FOREIGN KEY (idCategoria) REFERENCES CategoriaVeiculo(id)
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
    idVeiculo INT NOT NULL,
    idLinha INT NOT NULL,
    CONSTRAINT TB_Inspecao_Utilizador_Cliente_FK FOREIGN KEY (idCliente) REFERENCES Utilizador(id),
    CONSTRAINT TB_Inspecao_Utilizador_Inspetor_FK FOREIGN KEY (idInspetor) REFERENCES Utilizador(id),
    CONSTRAINT TB_Inspecao_Veiculo_FK FOREIGN KEY (idVeiculo) REFERENCES Veiculo(id),
    CONSTRAINT TB_Inspecao_LinhaInspecao_FK FOREIGN KEY (idLinha) REFERENCES LinhaInspecao(id)
);

INSERT INTO TipoUtilizador (nome) VALUES
    ('Administrador'), ('Inspector'), ('Cliente');

INSERT INTO Utilizador (nome, username, email, password, /*morada, cc, dataNasc,*/ telemovel, telefone, isActive, idTipo) VALUES
    ('José Rodrigues', 'admin', 'admin@mail.com',
     '$2y$12$OgKQmortu0reACW6sMmwz.nbCSPztT/SUWe399O48YKkWQSoV/j5u',
     /*'Rua Fonseca Porta 5, 6000-201', 15086126, '1990-05-05',*/ 912123168, NULL, TRUE, 1),
    ('Rodrigo Rafael', 'inspector', 'inspector@mail.com',
     '$2y$12$aWR7iVWNKAp12DQhSavGpOH9305vIUcH3NXyUlj8hMaTCX/r7uhX6',
     /*'Rua Liberdade Lote 123 3ºDireito, 6000-201', 15192310, '1981-07-27',*/ 925102312, NULL, TRUE, 2),
    ('Ricardo Pereira', 'cliente', 'cliente@mail.com',
     '$2y$12$5kqtya37Wf1ecQuDZybkSuxOaU.OxKb198L2wOH4ji8XFCrBZty3.',
     /*'Rua Fonseca Porta 10, 6000-201', 19212132, '2000-02-20',*/ 912323123, NULL, TRUE, 3);

INSERT INTO CategoriaVeiculo (nome, duracao) VALUES
    ('Ligeiro de passageiros', 30), ('Motociclo', 30), ('Pesado de mercadorias', 60);

INSERT INTO LinhaInspecao (nome, idCategoria) VALUES
    ('AutoExp', 1), ('AutoFpz', 1), ('Moto', 2), ('Cami', 3);