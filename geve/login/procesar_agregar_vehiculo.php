<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n_chasis = $_POST['nombre'];
    $n_chasis = $_POST['n_chasis'];
    $patente = $_POST['patente'];
    $marca = $_POST['marca'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];

    $sql = "INSERT INTO vehiculos (nombre,n_chasis, patente, marca, tipo_vehiculo) VALUES ('$n_chasis','$n_chasis', '$patente', '$marca', '$tipo_vehiculo')";

    if ($conn->query($sql) === TRUE) {
        echo "Vehículo agregado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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