CREATE TABLE usuario (
  id_usuario INT NOT NULL AUTO_INCREMENT,

  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  senha VARCHAR(100) NOT NULL,
  status BOOLEAN NOT NULL DEFAULT true,
  nivel ENUM('admin', 'usuario') NOT NULL,
  cadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id_usuario)
);


CREATE TABLE token(
  id_token INT NOT NULL AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  token TEXT NOT NULL,
  ip VARCHAR(100) NOT NULL,
  data_expira TIMESTAMP NOT NULL,
  data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_token),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);


CREATE TABLE categoria(
  id_categoria INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NULL DEFAULT NULL,
  PRIMARY KEY (id_categoria)
);



CREATE TABLE movimentacao (
  id_movimentacao INT NOT NULL AUTO_INCREMENT,
  id_usuario INT NOT NULL, -- Id do usuário que cadastrou
  id_categoria INT NOT NULL,

  nome VARCHAR(100) NOT NULL,
  valor DOUBLE NOT NULL DEFAULT 0,
  tipo ENUM('entrada','saida') NOT NULL,

  pago BOOLEAN NOT NULL DEFAULT false,
  descricao TEXT NULL DEFAULT NULL,
  vencimento DATE NOT NULL,

  recorrente BOOLEAN NOT NULL DEFAULT false,
  comprovante TEXT NULL DEFAULT NULL,
  dataPagamento DATE NULL DEFAULT NULL,

  cadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_movimentacao),
  FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);



