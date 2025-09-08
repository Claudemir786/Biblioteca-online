CREATE TABLE USUARIO(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    senha VARCHAR(50) NOT NULL
);

CREATE TABLE LIVRO(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    autor VARCHAR(150) NOT NULL,
    pagina INT NOT NULL,
    genero VARCHAR(100),
    editora VARCHAR(150),   
    isbn VARCHAR(20) UNIQUE,
    quantidade INT NOT NULL,
    ano_publicacao INT,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);



