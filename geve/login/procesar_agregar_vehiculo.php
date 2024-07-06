<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patente = $_POST['patente'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $observacion = $_POST['observacion'];
    $vencimientoRevision = $_POST['vencimientoRevision'];
    $vencimientoPermisoCirculacion = $_POST['vencimientoPermisoCirculacion'];
    $ano = $_POST['ano'];
    $nChasis = $_POST['nChasis'];
    $nMotor = $_POST['nMotor'];
    $nCarroceria = $_POST['nCarroceria'];
    $id_modelo = $_POST['id_modelo'];
    $id_modelo = $_POST['id_comprado'];


    $sql = "INSERT INTO Vehiculo (patente, fechaIngreso, observacion, vencimientoRevision, vencimientoPermisoCirculacion, ano, nChasis, nMotor, nCarroceria, id_modelo,id_comprado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sissssisssi", $patente, $fechaIngreso, $observacion, $vencimientoRevision, $vencimientoPermisoCirculacion, $ano, $nChasis, $nMotor, $nCarroceria, $id_modelo,$comprado);

        if ($stmt->execute()) {
            header("Location: welcome.php?success=1");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la declaración: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Procesar Agregar Vehículo</title>
</head>
<body>
    <a href="welcome.php">Volver a la página principal</a>
</body>
</html>

<?php
$conn->close();
?>