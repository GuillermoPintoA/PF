<?php
session_start();
include 'db.php';


$id_vehiculo = $_POST['id_vehiculo'];
$sql_nombre = "SELECT nombre FROM Vehiculo WHERE id_vehiculo = '$id_vehiculo'";

$result = $conn->query($sql_nombre);
$vehiculo = $result->fetch_assoc();
$nombre = $vehiculo['nombre'];

$sql = "DELETE FROM vehiculo WHERE id_vehiculo = '$id_vehiculo'";
if ($conn->query($sql) === TRUE) {
    // Registrar la acción en el historial
    $usuario = $_SESSION['nombre']. ' ' .$_SESSION['nombre'];
    $sql_historial = "INSERT INTO historial (id_vehiculo,nombre_vehiculo, accion, usuario) VALUES ('$id_vehiculo','$nombre', 'eliminado', '$usuario')";
    $conn->query($sql_historial);

    echo 'success';
} else {
    echo 'error';
}

$conn->close();
?>