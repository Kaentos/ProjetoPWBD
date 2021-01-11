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

CREATE TABLE MarcaVeiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL, 
    idCategoria INT NOT NULL,
    CONSTRAINT TB_Marca_CategoriaVeiculo_FK FOREIGN KEY (idCategoria) REFERENCES CategoriaVeiculo(id)
);

CREATE TABLE Veiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    matricula VARCHAR(6) NOT NULL UNIQUE,
    ano INT NOT NULL,
    idMarca INT NOT NULL,
    idCategoria INT NOT NULL,
    CONSTRAINT TB_Veiculo_MarcaVeiculo_FK FOREIGN KEY (idMarca) REFERENCES MarcaVeiculo(id),
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
    numero INT,
    idCategoria INT NOT NULL,
    CONSTRAINT TB_LinhaInspecao_CategoriaVeiculo_FK FOREIGN KEY (idCategoria) REFERENCES CategoriaVeiculo(id)
);

CREATE TABLE Inspecao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    horaInicio DATETIME NOT NULL,
    horaFim DATETIME NOT NULL,
    idCliente INT NOT NULL,
    idVeiculo INT NOT NULL,
    idInspetor INT,
    idLinha INT NOT NULL,
    CONSTRAINT TB_Inspecao_Utilizador_Cliente_FK FOREIGN KEY (idCliente) REFERENCES Utilizador(id),
    CONSTRAINT TB_Inspecao_Veiculo_FK FOREIGN KEY (idVeiculo) REFERENCES Veiculo(id),
    CONSTRAINT TB_Inspecao_Utilizador_Inspetor_FK FOREIGN KEY (idInspetor) REFERENCES Utilizador(id),
    CONSTRAINT TB_Inspecao_LinhaInspecao_FK FOREIGN KEY (idLinha) REFERENCES LinhaInspecao(id)
);

INSERT INTO TipoUtilizador VALUES
    (1, 'Administrador'), (2, 'Inspector'), (3, 'Cliente'), (0, "Apagado");

INSERT INTO Utilizador (nome, username, email, password, telemovel, telefone, isActive, idTipo) VALUES
    ('Jose Rodrigues', 'admin', 'admin@mail.com', '$2y$12$OgKQmortu0reACW6sMmwz.nbCSPztT/SUWe399O48YKkWQSoV/j5u', 912123168, NULL, TRUE, 1),
    ('Rodrigo Rafael', 'inspector', 'inspector@mail.com', '$2y$12$aWR7iVWNKAp12DQhSavGpOH9305vIUcH3NXyUlj8hMaTCX/r7uhX6', 925102312, NULL, TRUE, 2),
    ('Ricardo Pereira', 'cliente', 'cliente@mail.com', '$2y$12$5kqtya37Wf1ecQuDZybkSuxOaU.OxKb198L2wOH4ji8XFCrBZty3.', 912323123, NULL, TRUE, 3);

INSERT INTO CategoriaVeiculo VALUES
    (1, 'Ligeiro de passageiros', 30), (2, 'Motociclo', 30), (3, 'Pesado de mercadorias', 60);

INSERT INTO LinhaInspecao (nome, idCategoria) VALUES
    ('AutoExp', 1), ('AutoFpz', 1), ('Moto', 2), ('Cami', 3);

INSERT INTO MarcaVeiculo (nome, idCategoria) VALUES
    ('Audi', 1), ('BMW', 1), ('Cadillac', 1), ('Chevrolet', 1), ('Dodge', 1), 
    ('Ferrari', 1), ('Ford', 1), ('Honda', 1), ('Hummer', 1), ('Hyundai', 1),
    ('Infiniti', 1), ('Jaguar', 1), ('Jeep', 1), ('Kia', 1), ('Lamborghini', 1),
    ('Land Rover', 1), ('Lexus', 1), ('Lotus', 1), ('Mazda', 1), ('Mercedes-Benz', 1),
    ('Mitsubishi', 1), ('Nissan', 1), ('Renault', 1), ('Peugeot', 1), ('Porsche', 1),
    ('Subaru', 1), ('Suzuki', 1), ('Toyota', 1), ('Volkswagen', 1), ('Volvo', 1);

INSERT INTO MarcaVeiculo (nome, idCategoria) VALUES
    ('BMW', 2), ('Honda', 2), ('Yamaha', 2), ('Suzuki', 2), ('Peugeot', 2),
    ('Kawasaki', 2), ('KTM', 2), ('Kymco', 2), ('Harley-Davidson', 2), ('Ducati', 2);

INSERT INTO MarcaVeiculo (nome, idCategoria) VALUES
    ('Chevrolet', 3), ('Volkswagen', 3), ('Fiat', 3), ('Mercedes-Benz', 3), ('Ford', 3)
    ('Hyundai', 3), ('Kia', 3), ('Renault', 3), ('Scania', 3), ('Volvo', 2)
    ('Toyota', 3), ('Iveco', 3);