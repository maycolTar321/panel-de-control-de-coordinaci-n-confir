CREATE DATABASE IF NOT EXISTS sistema_coordinacion;
USE sistema_coordinacion;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    rol ENUM('coordinador', 'equipo') NOT NULL
);

CREATE TABLE IF NOT EXISTS actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    estado ENUM('pendiente', 'en_proceso', 'completado') DEFAULT 'pendiente',
    fecha_limite DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS actualizaciones_actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    actividad_id INT,
    usuario_id INT,
    detalle_estado TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (actividad_id) REFERENCES actividades(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

INSERT INTO usuarios (nombre, rol) VALUES ('Coordinador Principal', 'coordinador');
INSERT INTO usuarios (nombre, rol) VALUES ('Miembro del Equipo', 'equipo');

INSERT INTO actividades (titulo, estado, fecha_limite) VALUES ('Revisión de documentos', 'pendiente', '2024-12-01');
INSERT INTO actividades (titulo, estado, fecha_limite) VALUES ('Preparar presentación', 'en_proceso', '2024-11-25');
INSERT INTO actividades (titulo, estado, fecha_limite) VALUES ('Actualizar base de datos', 'completado', '2024-11-20');
