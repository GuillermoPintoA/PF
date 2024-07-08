use geve;
DROP TABLE IF EXISTS vehiculo;
CREATE TABLE Vehiculo (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    patente VARCHAR(255)  NOT NULL UNIQUE,
    fechaIngreso DATE,
    observacion TEXT,
    vencimientoRevision DATE,
    vencimientoPermisoCirculacion DATE,
    ano INT,
    nChasis VARCHAR(255)  NOT NULL UNIQUE,
    nMotor VARCHAR(255),
    nCarroceria VARCHAR(255),
    id_modelo INT,
     id_comprado INT,
     FOREIGN KEY (id_modelo) REFERENCES Modelo(id_modelo) ON DELETE CASCADE,
    FOREIGN KEY (id_comprado) REFERENCES Comprado(id_comprado) ON DELETE CASCADE
	
);
INSERT INTO Vehiculo (patente, fechaIngreso, observacion, vencimientoRevision, vencimientoPermisoCirculacion, ano, nChasis, nMotor, nCarroceria)
VALUES 
('AB1234',  '2021-03-15', 'Vehículo en buen estado', '2023-03-15', '2024-03-15', 2020, 'CH123456789', 'MO123456789', 'CA123456789'),
('CD5678', '2022-05-10', 'Vehículo arrendado', '2024-05-10', '2025-05-10', 2021, 'CH987654321', 'MO987654321', 'CA987654321'),
('EF9012', '2023-01-20', 'Vehículo en proceso de compra', '2025-01-20', '2026-01-20', 2022, 'CH112233445', 'MO112233445', 'CA112233445'),
('GH3456', '2020-11-30', 'Vehículo usado en buen estado', '2022-11-30', '2023-11-30', 2019, 'CH556677889', 'MO556677889', 'CA556677889'),
('IJ7890',  '2021-07-25', 'Vehículo en leasing', '2023-07-25', '2024-07-25', 2020, 'CH998877665', 'MO998877665', 'CA998877665');

CREATE TABLE cargo (
    id_cargo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);
INSERT INTO cargo (nombre) VALUES ('Super Admin'), ('Administrador'), ('Gerente'), ('Técnico'), ('Usuario'), ('RRHH');


ALTER TABLE usuario ADD COLUMN id_cargo INT DEFAULT  1;
ALTER TABLE usuario ADD CONSTRAINT fk_cargo FOREIGN KEY (id_cargo) REFERENCES cargo(id_cargo) ON DELETE CASCADE;

CREATE TABLE usuario (
    idusuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellidoP VARCHAR(255) NOT NULL,
    apellidoM VARCHAR(255) NOT NULL,
    cargo VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    fechacreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    claveweb VARCHAR(255) NOT NULL,
    rut VARCHAR(10) NOT NULL,
    dv_rut CHAR(1) NOT NULL
);
ALTER TABLE usuario drop COLUMN id_cargo ;


INSERT INTO usuario (nombre,apellidoP,apellidoM, cargo, mail, claveweb, rut, dv_rut)
VALUES
('Guillermo','Pinto', 'Pinto','Administrador', 'guillermo@gmail.com', 'password123', '20068559', '8'),
('Juan Pérez','Pérez', 'Pinto','Gerente', 'juan.perez@example.com', 'password123', '12345678', '9'),
('María','Gómez','Pinto', 'Administrador', 'maria.gomez@example.com', 'password456', '87654321', '0'),
('Pedro','Martínez', 'Pinto','Técnico', 'pedro.martinez@example.com', 'password789', '11223344', '1');

CREATE TABLE historial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_vehiculo INT,
    accion VARCHAR(50),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario VARCHAR(100),
    nombre_vehiculo VARCHAR(255),
    patente VARCHAR(100)
);
ALTER TABLE historial ADD COLUMN patente VARCHAR(255);

ALTER TABLE historial
ADD COLUMN nombre VARCHAR(100);


SELECT * FROM vehiculo;

SELECT * FROM historial;

SELECT * FROM historial_completo;

SELECT h.id, h.id_vehiculo, v.nombre AS nombre_vehiculo, h.accion, h.fecha, h.usuario
FROM historial h
LEFT JOIN vehiculo v ON h.id_vehiculo = v.id_vehiculo
ORDER BY h.fecha DESC;

CREATE TABLE reporte (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    id_vehiculo INT,
    fecha_reporte DATE,
    descripcion TEXT,
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculo(id_vehiculo) ON DELETE CASCADE
);
CREATE TABLE reporte (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    fecha_reporte DATE NOT NULL,
    descripcion TEXT,
    id_vehiculo INT,
    id_motivo INT,
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculo(id_vehiculo) ON DELETE CASCADE,
    FOREIGN KEY (id_motivo) REFERENCES motivo(id_motivo) ON DELETE CASCADE
);
DROP TABLE IF EXISTS comprado;	
CREATE TABLE reporte (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    fecha_reporte DATE NOT NULL,
    descripcion TEXT,
    id_vehiculo INT,
    id_motivo INT,
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculo(id_vehiculo) ON DELETE CASCADE,
    FOREIGN KEY (id_motivo) REFERENCES motivo(id_motivo) ON DELETE CASCADE
);
CREATE TABLE motivo (
    id_motivo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

INSERT INTO motivo (nombre) VALUES ('Falla técnica'), ('Falla técnica'),('Mantenimiento programado'), ('Accidente'), ('Otro');

ALTER TABLE reporte ADD COLUMN id_motivo INT,
    ADD CONSTRAINT fk_reporte_motivo FOREIGN KEY (id_motivo) REFERENCES motivo(id_motivo);
    
CREATE TABLE Documento (
    id_documento INT AUTO_INCREMENT PRIMARY KEY,
    id_vehiculo INT,
    nombre_archivo VARCHAR(255),
    ruta_archivo VARCHAR(255),
    tipo_archivo VARCHAR(50),
    fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculo(id_vehiculo) ON DELETE CASCADE
);
CREATE TABLE Marca (
    id_marca INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE Modelo (
    id_modelo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    id_marca INT,
    FOREIGN KEY (id_marca) REFERENCES Marca(id_marca) ON DELETE CASCADE
);
ALTER TABLE Vehiculo DROP COLUMN numeroInterno;
-- Insertamos vehículos asociados a modelos existentes
INSERT INTO Vehiculo (patente, fechaIngreso, observacion, vencimientoRevision, vencimientoPermisoCirculacion, ano, nChasis, nMotor, nCarroceria, id_modelo)
VALUES
('AB1234', 1, '2023-01-01', 'Observación 1', '2024-01-01', '2025-01-01', 2023, 'CH123456', 'M123456', 'C123456', 1),
('CD5678', 2, '2022-05-15', 'Observación 2', '2023-05-15', '2024-05-15', 2022, 'CH654321', 'M654321', 'C654321', 2),
('EF9012', 1, '2023-03-20', 'Observación 3', '2024-03-20', '2025-03-20', 2023, 'CH789012', 'M789012', 'C789012', 3);

ALTER TABLE Vehiculo ADD id_modelo INT, ADD FOREIGN KEY (id_modelo) REFERENCES Modelo(id_modelo) ON DELETE CASCADE;

INSERT INTO Marca (nombre) VALUES ('Toyota'), ('Ford'), ('Chevrolet');

INSERT INTO Modelo (nombre, id_marca) VALUES 
('Corolla', 1), ('Camry', 1), ('Hilux', 1),
('Fiesta', 2), ('Mustang', 2), ('Ranger', 2),
('Spark', 3), ('Cruze', 3), ('Silverado', 3);

CREATE TABLE Comprado (
    id_comprado INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(255) NOT NULL
);

INSERT INTO Comprado (tipo) VALUES ('Comprado'), ('Arrendado'), ('Otro');



CREATE TABLE estado (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL
);
INSERT INTO estado (descripcion) VALUES ('Activo'), ('Inactivo');

ALTER TABLE Vehiculo ADD COLUMN id_estado INT DEFAULT 1;
ALTER TABLE Vehiculo ADD CONSTRAINT fk_estado FOREIGN KEY (id_estado) REFERENCES estado(id_estado) ON DELETE CASCADE;

ALTER TABLE Vehiculo ADD COLUMN id_comprado INT, ADD FOREIGN KEY (id_comprado) REFERENCES Comprado(id_comprado) ON DELETE CASCADE;

ALTER TABLE vehiculo DROP FOREIGN KEY vehiculo_ibfk_2;
ALTER TABLE vehiculo ADD CONSTRAINT vehiculo_ibfk_2 FOREIGN KEY (id_comprado) REFERENCES comprado(id_comprado) ON DELETE CASCADE;