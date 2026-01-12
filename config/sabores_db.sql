CREATE DATABASE sabores_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sabores_db;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('cliente','admin') DEFAULT 'cliente',
  creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  imagen VARCHAR(255),
  categoria VARCHAR(100),
  activo TINYINT(1) DEFAULT 1
);

CREATE TABLE contacto_mensajes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  asunto VARCHAR(150),
  mensaje TEXT NOT NULL,
  creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NULL,
  total DECIMAL(10,2) NOT NULL,
  creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
  estado ENUM('pendiente','pagado','cancelado') DEFAULT 'pendiente',
  CONSTRAINT fk_pedidos_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE pedido_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  producto_id INT NOT NULL,
  cantidad INT NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  CONSTRAINT fk_items_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  CONSTRAINT fk_items_producto FOREIGN KEY (producto_id) REFERENCES productos(id)
);

DELIMITER $$
CREATE PROCEDURE sp_insert_contacto(
  IN p_nombre  VARCHAR(100),
  IN p_email   VARCHAR(150),
  IN p_asunto  VARCHAR(150),
  IN p_mensaje TEXT
)
BEGIN
  INSERT INTO contacto_mensajes(nombre, email, asunto, mensaje, creado_en)
  VALUES (p_nombre, p_email, p_asunto, p_mensaje, NOW());
END$$
DELIMITER ;

INSERT INTO productos (nombre, descripcion, precio, imagen, categoria, activo) VALUES
('Ceviche de Corvina', 'Ceviche fresco de corvina con limón.', 8.50, 'img/ceviche.jpg', 'Entradas', 1),
('Pulpo a la Parrilla', 'Pulpo marinado a la parrilla.', 15.00, 'img/pulpo.jpg', 'Platos Fuertes', 1),
('Filete de Pescado', 'Filete de pescado al ajillo.', 12.00, 'img/filete.jpg', 'Platos Fuertes', 1);
