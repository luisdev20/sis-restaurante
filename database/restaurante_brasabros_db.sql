CREATE DATABASE IF NOT EXISTS restaurante_brasabros_db;
USE restaurante_brasabros_db;
---CARTA
CREATE TABLE IF NOT EXISTS carta (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100)   NOT NULL,
    categoria   VARCHAR(50)    NOT NULL,
    descripcion TEXT,
    precio      DECIMAL(8,2)   NOT NULL,
    disponible  TINYINT(1)     DEFAULT 1,
    activo      TINYINT(1)     DEFAULT 1,
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO carta (nombre, categoria, descripcion, precio, disponible, activo) VALUES
('Pollo a la Brasa',          'Pollos y Parrillas', 'La especialidad de la casa, jugoso pollito a la brasa.',                              70.50, 1, 1),
('Chicharrón de Pollo',       'Pollos y Parrillas', 'Crocantes piezas de chicharrón de pollo.',                                           70.50, 1, 1),
('Costillas BBQ (Baby Back)', 'Pollos y Parrillas', 'Tiernas costillas de cerdo bañadas en nuestra salsa BBQ casera.',                    55.00, 1, 1),
('Anticuchos de Corazón',     'Pollos y Parrillas', 'Trozos de corazón macerados en ají panca y vinagre, servidos con papas doradas.',    28.00, 1, 1),
('Bife de Chorizo (300g)',    'Pollos y Parrillas', 'Corte argentino jugoso y con el borde de grasa perfecto para darle sabor.',          48.00, 1, 1),
('Mollejitas a la Parrilla',  'Pollos y Parrillas', 'Crocantes por fuera y suaves por dentro, con su toque de limón y ají de la casa.',  24.00, 1, 1),
('Chicha Morada',             'Bebidas',            'Refrescante chicha morada hecha en casa.',                                           15.00, 1, 1),
('Refresco Maracuyá',         'Bebidas',            'Refrescante refresco de maracuyá.',                                                  15.00, 1, 1);

--DELIVERY
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

--Tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) DEFAULT 'cliente', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nombre_completo, email, password, rol) 
VALUES ('Administrador Brasa Bros', 'admin@brasabros.com', 'admin123', 'admin');

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
ALTER TABLE reservas ADD COLUMN estado VARCHAR(20) DEFAULT 'confirmada;
