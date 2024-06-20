<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $comprado = isset($_POST['comprado']) ? 1 : 0;
    $fechaIngreso = $_POST['fechaIngreso'];
    $identificador = $_POST['identificador'];
    $observacion = $_POST['observacion'];
    $vencimientoRevision = $_POST['vencimientoRevision'];
    $vencimientoPermisoCirculacion = $_POST['vencimientoPermisoCirculacion'];
    $obsCompra = $_POST['obsCompra'];
    $ano = $_POST['ano'];
    $numeroInterno = $_POST['numeroInterno'];
    $nChasis = $_POST['nChasis'];
    $nMotor = $_POST['nMotor'];
    $nCarroceria = $_POST['nCarroceria'];

    $sql = "INSERT INTO Vehiculo (nombre, comprado, fechaIngreso, identificador, observacion, vencimientoRevision, vencimientoPermisoCirculacion, obsCompra, ano, numeroInterno, nChasis, nMotor, nCarroceria)
            VALUES ('$nombre', '$comprado', '$fechaIngreso', '$identificador', '$observacion', '$vencimientoRevision', '$vencimientoPermisoCirculacion', '$obsCompra', '$ano', '$numeroInterno', '$nChasis', '$nMotor', '$nCarroceria')";

    if ($conn->query($sql) === TRUE) {
        // Registrar la acción en el historial
        $usuario = $_SESSION['nombre']. ' ' .$_SESSION['nombre'];
        $id_vehiculo = $conn->insert_id;
        $sql_historial = "INSERT INTO historial (id_vehiculo,nombre_vehiculo, accion, usuario) VALUES ('$id_vehiculo','$nombre', 'agregado', '$usuario')";
        $conn->query($sql_historial);

        header("Location: welcome.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>

<html>
    
<head>
    <title>Agregar Vehículo</title>
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
    <div class="container">
        <h2>Agregar Vehículo</h2>
        <form method="post" action="agregar_vehiculo.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="comprado">Comprado:</label>
        <input type="checkbox" id="comprado" name="comprado"><br><br>
        <label for="fechaIngreso">Fecha de Ingreso:</label>
        <input type="date" id="fechaIngreso" name="fechaIngreso" required><br><br>
        <label for="identificador">Identificador:</label>
        <input type="text" id="identificador" name="identificador"><br><br>
        <label for="observacion">Observación:</label>
        <textarea id="observacion" name="observacion"></textarea><br><br>
        <label for="vencimientoRevision">Vencimiento de Revisión Técnica:</label>
        <input type="date" id="vencimientoRevision" name="vencimientoRevision" required><br><br>
        <label for="vencimientoPermisoCirculacion">Vencimiento del Permiso de Circulación:</label>
        <input type="date" id="vencimientoPermisoCirculacion" name="vencimientoPermisoCirculacion" required><br><br>
        <label for="obsCompra">Observación de la Compra:</label>
        <textarea id="obsCompra" name="obsCompra"></textarea><br><br>
        <label for="ano">Año:</label>
        <input type="number" id="ano" name="ano" required><br><br>
        <label for="numeroInterno">Número Interno:</label>
        <input type="text" id="numeroInterno" name="numeroInterno"><br><br>
        <label for="nChasis">Número de Chasis:</label>
        <input type="text" id="nChasis" name="nChasis"><br><br>
        <label for="nMotor">Número de Motor:</label>
        <input type="text" id="nMotor" name="nMotor"><br><br>
        <label for="nCarroceria">Número de Carrocería:</label>
        <input type="text" id="nCarroceria" name="nCarroceria"><br><br>
        <input type="submit" value="Agregar Vehículo">
    </form>
    </div>
</body>
</html>