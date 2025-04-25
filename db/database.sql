-- Crear la base de datos
CREATE DATABASE usuariosbd;
USE usuariosbd;

-- Crear tabla de registros de usuarios
CREATE TABLE registros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(30) NOT NULL UNIQUE,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(15) NOT NULL,
    telefono CHAR(9) NOT NULL,
    direccion VARCHAR(30) NOT NULL,
    edad TINYINT UNSIGNED NOT NULL CHECK (edad BETWEEN 1 AND 99)
);

-- Insertar algunos datos de ejemplo
INSERT INTO registros (correo, usuario, contrasena, telefono, direccion, edad) VALUES
('andrea@gmail.com', 'andrea123', 'andrea12345', '915478632', 'Jr Las Orquideas',26),
('maria@gmail.com', 'maria123', 'maria12345', '949781246', 'Jr Las Nogales',28);