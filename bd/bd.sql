-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `web_la_lupe` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_la_lupe`;

-- 1. Tabla de Usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('cliente', 'admin') DEFAULT 'cliente',
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabla de Platos (Menú)
CREATE TABLE IF NOT EXISTS `platos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT,
  `precio` DECIMAL(10, 2) NOT NULL,
  `imagen` VARCHAR(255) DEFAULT 'default_plato.jpg',
  `disponible` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

-- 3. Tabla de Pedidos (Para la Fase 3)
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT,
  `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `total` DECIMAL(10, 2),
  `estado` ENUM('pendiente', 'preparando', 'completado') DEFAULT 'pendiente',
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insertar un administrador de prueba (la contraseña es 'admin123' hasheada)
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`) VALUES 
('Admin La Lupe', 'admin@lalupe.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insertar unos platos de ejemplo
INSERT INTO `platos` (`nombre`, `descripcion`, `precio`, `imagen`) VALUES 
('Tacos al Pastor', 'Deliciosos tacos de cerdo marinado con piña.', 8.50, 'tacos.jpg'),
('Enchiladas Verdes', 'Tortillas rellenas de pollo con salsa verde suiza.', 10.00, 'enchiladas.jpg'),
('Guacamole Especial', 'Aguacate fresco con totopos artesanales.', 6.50, 'guacamole.jpg');