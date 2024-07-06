<?php
session_start();
include 'db.php';



// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id_vehiculo'])) {
    echo "ID de vehículo no proporcionado.";
    exit();
}

// Obtener el ID del vehículo desde la URL
$id_vehiculo = $_GET['id_vehiculo'];

// Consultar los detalles del vehículo
$sql = "SELECT * FROM Vehiculo WHERE id_vehiculo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_vehiculo);
$stmt->execute();
$result = $stmt->get_result();
$vehiculo = $result->fetch_assoc();

// Consultar modelos para el dropdown
$sql_modelos = "SELECT id_modelo, nombre FROM Modelo";
$result_modelos = $conn->query($sql_modelos);
$modelos = $result_modelos->fetch_all(MYSQLI_ASSOC);

// Si el formulario se envía, actualizar los detalles del vehículo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patente = $_POST['patente'];
    $comprado = isset($_POST['comprado']) ? 1 : 0;
    $fechaIngreso = $_POST['fechaIngreso'];
    $observacion = $_POST['observacion'];
    $vencimientoRevision = $_POST['vencimientoRevision'];
    $vencimientoPermisoCirculacion = $_POST['vencimientoPermisoCirculacion'];
    $ano = $_POST['ano'];
    $nChasis = $_POST['nChasis'];
    $nMotor = $_POST['nMotor'];
    $nCarroceria = $_POST['nCarroceria'];
    $id_modelo = $_POST['id_modelo'];

    $sql_update = "UPDATE Vehiculo SET patente = ?, comprado = ?, fechaIngreso = ?, observacion = ?, vencimientoRevision = ?, vencimientoPermisoCirculacion = ?, ano = ?, nChasis = ?, nMotor = ?, nCarroceria = ?, id_modelo = ? WHERE id_vehiculo = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sissssisssii", $patente, $comprado, $fechaIngreso, $observacion, $vencimientoRevision, $vencimientoPermisoCirculacion, $ano, $nChasis, $nMotor, $nCarroceria, $id_modelo, $id_vehiculo);
    $stmt_update->execute();

    // Manejar la subida de documentos
    if (isset($_FILES['documento'])) {
        $documento = $_FILES['documento'];
        $nombre_documento = $documento['name'];
        $ruta_documento = 'uploads/' . $nombre_documento;

        if (move_uploaded_file($documento['tmp_name'], $ruta_documento)) {
            $sql_documento = "INSERT INTO Documento (id_vehiculo, nombre_documento, ruta_documento) VALUES (?, ?, ?)";
            $stmt_documento = $conn->prepare($sql_documento);
            $stmt_documento->bind_param("iss", $id_vehiculo, $nombre_documento, $ruta_documento);
            $stmt_documento->execute();
        }
    }

    // Redirigir después de la actualización
    header("Location: editar_vehiculo.php?id_vehiculo=$id_vehiculo&success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Vehículo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color:  #d73c3e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color:  #d73c3e;
        }
    </style>
</head>
<body>
    <h1>Editar Vehículo</h1>
    <?php if (isset($_GET['success'])): ?>
        <p>¡Vehículo actualizado exitosamente!</p>
    <?php endif; ?>
    <form action="editar_vehiculo.php?id_vehiculo=<?= $id_vehiculo ?>" method="post" enctype="multipart/form-data">
        <label for="patente">Patente:</label>
        <input type="text" name="patente" value="<?= $vehiculo['patente'] ?>" required pattern="[A-Z]{2}[0-9]{4}"><br>

        <label for="comprado">Comprado:</label>
        <input type="checkbox" name="comprado" <?= $vehiculo['comprado'] ? 'checked' : '' ?>><br>

        <label for="fechaIngreso">Fecha de Ingreso:</label>
        <input type="date" name="fechaIngreso" value="<?= $vehiculo['fechaIngreso'] ?>" required><br>

        <label for="observacion">Observación:</label>
        <textarea name="observacion" required><?= $vehiculo['observacion'] ?></textarea><br>

        <label for="vencimientoRevision">Vencimiento de Revisión:</label>
        <input type="date" name="vencimientoRevision" value="<?= $vehiculo['vencimientoRevision'] ?>" required><br>

        <label for="vencimientoPermisoCirculacion">Vencimiento de Permiso de Circulación:</label>
        <input type="date" name="vencimientoPermisoCirculacion" value="<?= $vehiculo['vencimientoPermisoCirculacion'] ?>" required><br>

        <label for="ano">Año:</label>
        <input type="number" name="ano" value="<?= $vehiculo['ano'] ?>" required><br>

        <label for="nChasis">Número de Chasis:</label>
        <input type="text" name="nChasis" value="<?= $vehiculo['nChasis'] ?>" required><br>

        <label for="nMotor">Número de Motor:</label>
        <input type="text" name="nMotor" value="<?= $vehiculo['nMotor'] ?>" required><br>

        <label for="nCarroceria">Número de Carrocería:</label>
        <input type="text" name="nCarroceria" value="<?= $vehiculo['nCarroceria'] ?>" required><br>

        <label for="id_modelo">Modelo:</label>
        <select name="id_modelo" required>
            <?php foreach ($modelos as $modelo): ?>
                <option value="<?= $modelo['id_modelo'] ?>" <?= $vehiculo['id_modelo'] == $modelo['id_modelo'] ? 'selected' : '' ?>>
                    <?= $modelo['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="documento">Agregar Documento:</label>
        <input type="file" name="documento" accept=".pdf,.png"><br>

        <input type="submit" value="Actualizar Vehículo">
    </form>

    <h2>Documentos Asociados</h2>
    <?php
    // Consultar documentos asociados al vehículo
    $sql_documentos = "SELECT * FROM Documento WHERE id_vehiculo = ?";
    $stmt_documentos = $conn->prepare($sql_documentos);
    $stmt_documentos->bind_param("i", $id_vehiculo);
    $stmt_documentos->execute();
    $result_documentos = $stmt_documentos->get_result();

    if ($result_documentos->num_rows > 0): ?>
        <ul>
            <?php while($documento = $result_documentos->fetch_assoc()): ?>
                <li>
                    <a href="<?= $documento['ruta_documento'] ?>" download><?= $documento['nombre_documento'] ?></a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No hay documentos asociados.</p>
    <?php endif; ?>
</body>
    
        
</html>