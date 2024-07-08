<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ver_vehiculo_detalle.php?id_vehiculo=$id_vehiculo");
    exit();
}

// Verifica si se ha pasado el ID del vehículo por GET
if (!isset($_GET['id'])) {
    echo "ID de vehículo no proporcionado.";
    exit();
}

$id_vehiculo = $_GET['id'];

$sql = "SELECT v.*, c.tipo AS tipo_comprado, m.nombre AS modelo, ma.nombre AS marca 
FROM Vehiculo v
JOIN Comprado c ON v.id_comprado = c.id_comprado
JOIN Modelo m ON v.id_modelo = m.id_modelo
JOIN Marca ma ON m.id_marca = ma.id_marca
WHERE v.id_vehiculo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_vehiculo);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows == 0) {
    echo "Vehículo no encontrado.";
    exit();
}

$vehiculo = $result->fetch_assoc();


$sql_docs = "SELECT * FROM Documento WHERE id_vehiculo = ?";
$stmt_docs = $conn->prepare($sql_docs);
$stmt_docs->bind_param("i", $id_vehiculo);
$stmt_docs->execute();
$result_docs = $stmt_docs->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalle del Vehículo</title>
    <style>
        .vehicle-details {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .vehicle-details h2 {
            text-align: center;
        }
        .vehicle-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .vehicle-details th, .vehicle-details td {
            padding: 10px;
            text-align: left;
        }
        .vehicle-details th {
            background-color: #f2f2f2;
        }
        .btn-back {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color:  #d73c3e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    
        .documents {
            margin-top: 20px;
        }
        .documents table {
            width: 100%;
            border-collapse: collapse;
        }
        .documents th, .documents td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .documents th {
            background-color: #f2f2f2;
        }
        .btn-upload {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color:  #d73c3e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="vehicle-details">
        <h2>Detalle del Vehículo</h2>
        <table>
            <tr>
                <th>ID Vehículo</th>
                <td><?php echo htmlspecialchars($vehiculo['id_vehiculo']); ?></td>
            </tr>
            <tr>
                <th>Patente</th>
                <td><?php echo htmlspecialchars($vehiculo['patente']); ?></td>
            </tr>
            <tr>
            <th>Estado</th>
            <td><?php echo $vehiculo['tipo_comprado']; ?></td>
        </tr>
            <tr>
                <th>Fecha de Ingreso</th>
                <td><?php echo htmlspecialchars($vehiculo['fechaIngreso']); ?></td>
            </tr>
            <tr>
                <th>Observación</th>
                <td><?php echo nl2br(htmlspecialchars($vehiculo['observacion'])); ?></td>
            </tr>
            <tr>
                <th>Vencimiento Revisión Técnica</th>
                <td><?php echo htmlspecialchars($vehiculo['vencimientoRevision']); ?></td>
            </tr>
            <tr>
                <th>Vencimiento Permiso Circulación</th>
                <td><?php echo htmlspecialchars($vehiculo['vencimientoPermisoCirculacion']); ?></td>
            </tr>
            <tr>
                <th>Marca</th>
                <td><?php echo htmlspecialchars($vehiculo['marca']); ?></td>
            </tr>
            <tr>
                <th>Modelo</th>
                <td><?php echo htmlspecialchars($vehiculo['modelo']); ?></td>
            </tr>
            <tr>
                <th>Año</th>
                <td><?php echo htmlspecialchars($vehiculo['ano']); ?></td>
            </tr>
            <tr>
                <th>Número de Chasis</th>
                <td><?php echo htmlspecialchars($vehiculo['nChasis']); ?></td>
            </tr>
            <tr>
                <th>Número de Motor</th>
                <td><?php echo htmlspecialchars($vehiculo['nMotor']); ?></td>
            </tr>
            <tr>
                <th>Número de Carrocería</th>
                <td><?php echo htmlspecialchars($vehiculo['nCarroceria']); ?></td>
            </tr>
        </table>
        
        <div class="documents">
            <h3>Documentos</h3>
            <form action="upload_document.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_vehiculo" value="<?php echo $id_vehiculo; ?>">
                <input type="file" name="archivo" accept=".pdf, .png, .jpg" required>
                <button type="submit" class="btn-upload">Subir Documento</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Fecha de Subida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_docs->num_rows > 0) {
                        while($doc = $result_docs->fetch_assoc()) {
                            echo "<tr>
                                <td>{$doc['nombre_archivo']}</td>
                                <td>{$doc['tipo_archivo']}</td>
                                <td>{$doc['fecha_subida']}</td>
                                <td>
                                    <a href='{$doc['ruta_archivo']}' download>Descargar</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay documentos</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="welcome.php" class="btn-back">Volver</a>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
