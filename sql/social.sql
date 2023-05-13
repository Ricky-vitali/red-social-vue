DROP DATABASE IF EXISTS social;
CREATE DATABASE IF NOT EXISTS social;
USE social;

/* Tabla de Usuarios */
CREATE TABLE IF NOT EXISTS users (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	user VARCHAR(30) UNIQUE NOT NULL,
	name VARCHAR(45) NOT NULL,
    surname VARCHAR(45) NOT NULL,
	email VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	biography VARCHAR(255),
	created_at TIMESTAMP NOT NULL ,
	PRIMARY KEY (id)

)ENGINE = InnoDB;

/* Tabla de Post*/
CREATE TABLE IF NOT EXISTS posts(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	content VARCHAR(255) NOT NULL,
	created_at TIMESTAMP NOT NULL,
	user_id INT UNSIGNED NOT NULL,

	FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE CASCADE,

	PRIMARY KEY (id)
)ENGINE = InnoDB;

/* Table de comentarios */
CREATE TABLE IF NOT EXISTS comments(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	content VARCHAR(255) NOT NULL,
	created_at TIMESTAMP NOT NULL,
	post_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,

	FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE NO ACTION ON UPDATE CASCADE,
	FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE CASCADE,

	PRIMARY KEY (id)
)ENGINE = InnoDB;

INSERT INTO users (id,user, name, surname, email, password, biography, created_at) VALUES (1,'Rickyvit', 'Ricardo', 'Vitali', 'ricardo.vitali@davinci.edu.ar', '$2y$10$SQmb4fqgh0cff7lQH0ZCQuS/SnkxbNHLdR4Wly2ij7ZSE1tC/KxO6', NULL, '2021-07-08 06:10:22');

INSERT INTO posts (id,content, created_at, user_id) VALUES (1,'Este es el post mas bonito de todos!', '2021-07-08 06:10:22', 1);

INSERT INTO posts (id,content, created_at, user_id) VALUES (2,'Profe apruebeme por favor', '2021-07-08 06:10:22', 1);

INSERT INTO comments (id,content, created_at, post_id, user_id) VALUES (1,'Probando si los comentarios andan', '2021-07-08 06:10:22', 1, 1);