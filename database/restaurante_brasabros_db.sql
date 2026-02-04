CREATE DATABASE IF NOT EXISTS restaurante_brasabros_db;
USE restaurante_brasabros_db;

-- Tabla para reservas
CREATE TABLE reservas (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100),
email VARCHAR(150),
telefono VARCHAR(150),
fecha DATE,
hora TIME,
invitados INT
);

-- Tabla para pedidos de delivery
CREATE TABLE IF NOT EXISTS pedidos_delivery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    referencia VARCHAR(255),
    metodo_pago VARCHAR(50) NOT NULL,
    producto VARCHAR(255) NOT NULL,
    fecha_pedido DATETIME NOT NULL,
    estado VARCHAR(50) DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
