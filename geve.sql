use geve;

CREATE TABLE Vehiculo (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    comprado BOOLEAN NOT NULL,
    fechaIngreso DATE,
    identificador VARCHAR(255),
    observacion TEXT,
    vencimientoRevision DATE,
    vencimientoPermisoCirculacion DATE,
    obsCompra TEXT,
    ano INT,
    numeroInterno VARCHAR(255),
    nChasis VARCHAR(255),
    nMotor VARCHAR(255),
    nCarroceria VARCHAR(255)
);

INSERT INTO Vehiculo (nombre, comprado, fechaIngreso, identificador, observacion, vencimientoRevision, vencimientoPermisoCirculacion, obsCompra, ano, numeroInterno, nChasis, nMotor, nCarroceria)
VALUES ('Toyota Corolla', 1, '2023-01-15', 'TBGD34', 'Vehículo en buen estado', '2024-03-15', '2024-04-30', 'Sin observaciones', 2023, 'A123', 'CH123', 'M123', 'C123');

INSERT INTO Vehiculo (nombre, comprado, fechaIngreso, identificador, observacion, vencimientoRevision, vencimientoPermisoCirculacion, obsCompra, ano, numeroInterno, nChasis, nMotor, nCarroceria)
VALUES ('Ford Mustang', 1, '2022-06-30', 'XYZT56', 'Vehículo deportivo', '2023-12-30', '2023-08-31', 'Detalles de la compra', 2022, 'B456', 'CH456', 'M456', 'C456');

INSERT INTO Vehiculo (nombre, comprado, fechaIngreso, identificador, observacion, vencimientoRevision, vencimientoPermisoCirculacion, obsCompra, ano, numeroInterno, nChasis, nMotor, nCarroceria)
VALUES ('Honda Civic', 0, '2020-09-20', 'DEFT89', 'Vehículo en reparación', '2022-11-20', '2022-10-15', 'Compra pendiente', 2020, 'C789', 'CH789', 'M789', 'C789');


CREATE TABLE Cargo (
    idCargo INT AUTO_INCREMENT PRIMARY KEY,
    subIdCargo INT,
    idEmpresa INT,
    nombreCargo VARCHAR(255) NOT NULL,
    fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Activo', 'Inactivo') NOT NULL
);


CREATE TABLE Empresa (
    idEmpresa INT AUTO_INCREMENT PRIMARY KEY,
    rutEmpresa VARCHAR(20) NOT NULL,
    digitoVerificador CHAR(1) NOT NULL,
    nombreEmpresa VARCHAR(255) NOT NULL,
    rubroEmpresa VARCHAR(255),
    tamanoEmpresa VARCHAR(50),
    ciudadEmpresa VARCHAR(255),
    regionEmpresa VARCHAR(255),
    fechaIngreso DATE,
    rutRepresentanteLegal VARCHAR(20) NOT NULL,
    dvRepresentanteLegal CHAR(1) NOT NULL,
    estado ENUM('Activo', 'Inactivo') NOT NULL,
    direccion VARCHAR(255),
    fonoOC VARCHAR(20),
    mailOC VARCHAR(255)
);

CREATE TABLE Marca (
    idMarca INT AUTO_INCREMENT PRIMARY KEY,
    nombreMarca VARCHAR(255) NOT NULL,
    estado ENUM('Activo', 'Inactivo') NOT NULL
);
INSERT INTO Marca (nombreMarca, estado) VALUES
('Toyota', 'Activo'),
('Honda', 'Activo'),
('Ford', 'Activo'),
('Chevrolet', 'Activo'),
('Nissan', 'Activo'),
('BMW', 'Activo'),
('Mercedes-Benz', 'Activo'),
('Audi', 'Activo'),
('Volkswagen', 'Activo'),
('Hyundai', 'Activo');

CREATE TABLE Modelo (
    idModelo INT AUTO_INCREMENT PRIMARY KEY,
    idMarca INT,
    nombreModelo VARCHAR(255) NOT NULL,
    estado ENUM('Activo', 'Inactivo') NOT NULL,
    FOREIGN KEY (idMarca) REFERENCES Marca(idMarca)
);

INSERT INTO Modelo (idMarca, nombreModelo, estado) VALUES
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Toyota'), 'Corolla', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Toyota'), 'Camry', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Honda'), 'Civic', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Honda'), 'Accord', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Ford'), 'F-150', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Ford'), 'Mustang', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Chevrolet'), 'Silverado', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Chevrolet'), 'Malibu', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Nissan'), 'Altima', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Nissan'), 'Sentra', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'BMW'), '3 Series', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'BMW'), '5 Series', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Mercedes-Benz'), 'C-Class', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Mercedes-Benz'), 'E-Class', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Audi'), 'A4', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Audi'), 'Q5', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Volkswagen'), 'Golf', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Volkswagen'), 'Passat', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Hyundai'), 'Elantra', 'Activo'),
((SELECT idMarca FROM Marca WHERE nombreMarca = 'Hyundai'), 'Santa Fe', 'Activo');

CREATE TABLE usuario (
    idusuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    cargo VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    fechacreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    claveweb VARCHAR(255) NOT NULL,
    rut VARCHAR(10) NOT NULL,
    dv_rut CHAR(1) NOT NULL
);

ALTER TABLE usuario ADD COLUMN nombre VARCHAR(255), ADD COLUMN apellido VARCHAR(255);

INSERT INTO usuario (nombre,apellido, cargo, mail, claveweb, rut, dv_rut)
VALUES
('Guillermo','Pinto', 'Administrador', 'guillermo@gmail.com', 'password123', '20068559', '8'),
('Juan Pérez','Pérez', 'Gerente', 'juan.perez@example.com', 'password123', '12345678', '9'),
('María','Gómez', 'Administrador', 'maria.gomez@example.com', 'password456', '87654321', '0'),
('Pedro','Martínez', 'Técnico', 'pedro.martinez@example.com', 'password789', '11223344', '1');

CREATE TABLE historial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_vehiculo INT,
    accion VARCHAR(50),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario VARCHAR(100)
);
ALTER TABLE historial ADD COLUMN nombre_vehiculo VARCHAR(255);

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
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculo(id_vehiculo)
);

CREATE TABLE motivo (
    id_motivo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

INSERT INTO motivo (nombre) VALUES ('Falla técnica'), ('Mantenimiento programado'), ('Accidente'), ('Otro');

ALTER TABLE reporte ADD COLUMN id_motivo INT,
    ADD CONSTRAINT fk_reporte_motivo FOREIGN KEY (id_motivo) REFERENCES motivo(id_motivo);
    
CREATE TABLE Documento (
    id_documento INT AUTO_INCREMENT PRIMARY KEY,
    id_vehiculo INT,
    nombre_archivo VARCHAR(255),
    ruta_archivo VARCHAR(255),
    tipo_archivo VARCHAR(50),
    fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculo(id_vehiculo)
);