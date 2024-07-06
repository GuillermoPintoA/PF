<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_vehiculo = $_GET['id'];

    $sql = "SELECT * FROM Vehiculo WHERE id_vehiculo = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_vehiculo);
        $stmt->execute();
        $result = $stmt->get_result();
        $vehiculo = $result->fetch_assoc();
        $stmt->close();
    } else {
        echo "Error en la preparación de la declaración: " . $conn->error;
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_vehiculo = $_POST['id_vehiculo'];
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

    // Verificar cambios
    $sql_check = "SELECT * FROM Vehiculo WHERE id_vehiculo = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("i", $id_vehiculo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $vehiculo_orig = $result_check->fetch_assoc();
        $stmt_check->close();

        $cambios = [];
        foreach ($vehiculo_orig as $campo => $valor_orig) {
            if ($vehiculo_orig[$campo] != $$campo) {
                $cambios[] = $campo;
            }
        }

        if (!empty($cambios) || isset($_POST['confirm'])) {
            $sql = "UPDATE Vehiculo SET patente = ?, comprado = ?, fechaIngreso = ?, observacion = ?, vencimientoRevision = ?, vencimientoPermisoCirculacion = ?, ano = ?, nChasis = ?, nMotor = ?, nCarroceria = ?, id_modelo = ? WHERE id_vehiculo = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sissssisssii", $patente, $comprado, $fechaIngreso, $observacion, $vencimientoRevision, $vencimientoPermisoCirculacion, $ano, $nChasis, $nMotor, $nCarroceria, $id_modelo, $id_vehiculo);

                if ($stmt->execute()) {
                    // Manejar carga de archivos
                    if ($_FILES['archivo']['name']) {
                        $target_dir = "uploads/";
                        $target_file = $target_dir . basename($_FILES["archivo"]["name"]);
                        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Validar tipo de archivo
                        if ($fileType != "pdf" && $fileType != "png") {
                            echo "Solo se permiten archivos PDF y PNG.";
                        } else {
                            if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
                                // Guardar el archivo en la base de datos
                                $sql_file = "INSERT INTO Archivos (id_vehiculo, nombre_archivo, ruta_archivo) VALUES (?, ?, ?)";
                                if ($stmt_file = $conn->prepare($sql_file)) {
                                    $stmt_file->bind_param("iss", $id_vehiculo, $_FILES["archivo"]["name"], $target_file);
                                    $stmt_file->execute();
                                    $stmt_file->close();
                                }
                            } else {
                                echo "Hubo un error al subir el archivo.";
                            }
                        }
                    }

                    header("Location: ver_vehiculo_detalle.php?id=$id_vehiculo");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error en la preparación de la declaración: " . $conn->error;
            }
        } else {
            echo "<script>
                if (confirm('No se han realizado cambios. ¿Desea continuar?')) {
                    document.forms['editForm'].submit();
                } else {
                    window.location.href = 'editar_vehiculo.php?id=$id_vehiculo';
                }
            </script>";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>
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
    <script>
        function confirmSubmit() {
            var cambios = <?php echo json_encode($cambios); ?>;
            if (cambios.length === 0) {
                return confirm('No se han realizado cambios. ¿Desea continuar?');
            }
            return true;
        }
    </script>
</head>
<body>
<div class="vehicle-details">
    <h1>Editar Vehículo</h1>
    <table>
    <form name="editForm" action="editar_vehiculo.php" method="post" enctype="multipart/form-data" onsubmit="return confirmSubmit()">
    <tr> 
        <input type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo'] ?? ''; ?>">
        <input type="hidden" name="confirm" value="1">
        </tr>
        <tr>
        <label for="patente">Patente:</label>
        <input type="text" name="patente" value="<?php echo $vehiculo['patente'] ?? ''; ?>" required pattern="[A-Z]{2}[0-9]{4}"><br>
        </tr>
        <label for="comprado">Comprado:</label>
        <input type="checkbox" name="comprado" <?php echo isset($vehiculo['comprado']) && $vehiculo['comprado'] ? 'checked' : ''; ?>><br>

        <label for="fechaIngreso">Fecha de Ingreso:</label>
        <input type="date" name="fechaIngreso" value="<?php echo $vehiculo['fechaIngreso'] ?? ''; ?>" required><br>

        <label for="observacion">Observación:</label>
        <textarea name="observacion" required><?php echo $vehiculo['observacion'] ?? ''; ?></textarea><br>

        <label for="vencimientoRevision">Vencimiento de Revisión:</label>
        <input type="date" name="vencimientoRevision" value="<?php echo $vehiculo['vencimientoRevision'] ?? ''; ?>" required><br>

        <label for="vencimientoPermisoCirculacion">Vencimiento de Permiso de Circulación:</label>
        <input type="date" name="vencimientoPermisoCirculacion" value="<?php echo $vehiculo['vencimientoPermisoCirculacion'] ?? ''; ?>" required><br>

        <label for="ano">Año:</label>
        <input type="number" name="ano" value="<?php echo $vehiculo['ano'] ?? ''; ?>" required><br>

        <label for="nChasis">Número de Chasis:</label>
        <input type="text" name="nChasis" value="<?php echo $vehiculo['nChasis'] ?? ''; ?>" required><br>

        <label for="nMotor">Número de Motor:</label>
        <input type="text" name="nMotor" value="<?php echo $vehiculo['nMotor'] ?? ''; ?>" required><br>

        <label for="nCarroceria">Número de Carrocería:</label>
        <input type="text" name="nCarroceria" value="<?php echo $vehiculo['nCarroceria'] ?? ''; ?>" required><br>

        <label for="id_modelo">Modelo:</label>
        <select name="id_modelo" required>
            <?php
            include 'db.php';
            $sql_modelos = "SELECT id_modelo, nombre FROM Modelo";
            $result_modelos = $conn->query($sql_modelos);
            while ($modelo = $result_modelos->fetch_assoc()) {
                $selected = isset($vehiculo['id_modelo']) && $vehiculo['id_modelo'] == $modelo['id_modelo'] ? 'selected' : '';
                echo "<option value='{$modelo['id_modelo']}' $selected>{$modelo['nombre']}</option>";
            }
            $conn->close();
            ?>
        </select><br>
        </table>
        <label for="archivo">Subir Documento (PDF o PNG):</label>
        <input type="file" name="archivo"><br>

        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
