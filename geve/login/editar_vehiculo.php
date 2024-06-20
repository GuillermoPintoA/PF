<?php
session_start();
include 'db.php';



// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_vehiculo = $_POST['id_vehiculo'];
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

    $sql = "UPDATE Vehiculo SET nombre='$nombre', comprado='$comprado', fechaIngreso='$fechaIngreso', identificador='$identificador', observacion='$observacion', vencimientoRevision='$vencimientoRevision', vencimientoPermisoCirculacion='$vencimientoPermisoCirculacion', obsCompra='$obsCompra', ano='$ano', numeroInterno='$numeroInterno', nChasis='$nChasis', nMotor='$nMotor', nCarroceria='$nCarroceria' WHERE id_vehiculo='$id_vehiculo'";

    if ($conn->query($sql) === TRUE) {
        // Registrar la acción en el historial
        $usuario = $_SESSION['nombre']. ' ' .$_SESSION['apellido'];
        $sql_historial = "INSERT INTO historial (id_vehiculo,nombre_vehiculo, accion, usuario) VALUES ('$id_vehiculo','$nombre', 'editado', '$usuario')";
        $conn->query($sql_historial);

        header("Location: welcome.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $id_vehiculo = $_GET['id'];
    $sql = "SELECT * FROM Vehiculo WHERE id_vehiculo='$id_vehiculo'";
    $result = $conn->query($sql);
    $vehiculo = $result->fetch_assoc();
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
    <div class="container mt-5">
        <div class="card">
            <h5 class="card-header">Editar Vehículo</h5>
            <div class="card-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo']; ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $vehiculo['nombre']; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="comprado">Comprado:</label>
                        <input type="checkbox" id="comprado" name="comprado" <?php if($vehiculo['comprado']) echo "checked"; ?>>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha de Ingreso:</label>
                        <input type="date" id="fechaIngreso" name="fechaIngreso" <?php if($vehiculo['fechaIngreso']) echo "checked"; ?>>
                    </div>
                    <div class="form-group">
                        <label for="identificador">Identificador:</label>
                        <input type="text" id="Identificador" name="Identificador" <?php if($vehiculo['identificador']) echo "checked"; ?>>
                    </div>
                    <div class="form-group">
                        <label for="observacion">Observacion:</label>
                        <input type="text" id="observacion" name="observacion" <?php if($vehiculo['observacion']) echo "checked"; ?>>
                    </div>
                    <div class="form-group">
                        <label for="vencimientoRevision">Vencimiento Revision:</label>
                        <input type="date" id="vencimientoRevision" name="vencimientoRevision" <?php if($vehiculo['vencimientoRevision']) echo "checked"; ?>>
                    </div>
                    <div class="form-group">
                        <label for="vencimientoPermisoCirculacion">Vencimiento Permiso Circulacion:</label>
                        <input type="date" id="vencimientoPermisoCirculacion" name="vencimientoPermisoCirculacion" <?php if($vehiculo['vencimientoPermisoCirculacion']) echo "checked"; ?>>
                    </div>
                    <div class="form-group">
                        <label for="numeroInterno">Numero Interno:</label>
                        <input type="text" id="numeroInterno" name="numeroInterno" <?php if($vehiculo['numeroInterno']) echo "checked"; ?>>
                    </div>
                    <div class="form-group">
                    <label for="nChasis">Número de Chasis:</label>
        <input type="text" id="nChasis" name="nChasis" value="<?php echo $vehiculo['nChasis']; ?>"><br><br>
        <label for="nMotor">Número de Motor:</label>
        <input type="text" id="nMotor" name="nMotor" value="<?php echo $vehiculo['nMotor']; ?>"><br><br>
        <label for="nCarroceria">Número de Carrocería:</label>
        <input type="text" id="nCarroceria" name="nCarroceria" value="<?php echo $vehiculo['nCarroceria']; ?>"><br><br>
    </div>
                    <!-- Agregar más campos según tu estructura de vehículos -->
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y jQuery (si es necesario) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
    
        
</html>