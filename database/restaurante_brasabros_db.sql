CREATE DATABASE IF NOT EXISTS restaurante_brasabros_db;
USE restaurante_brasabros_db;

CREATE TABLE reservas (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100),
email VARCHAR(150),
telefono VARCHAR(150),
fecha DATE,
hora TIME,
invitados INT
);
