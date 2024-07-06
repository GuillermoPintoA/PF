<?php
session_start();
include 'db.php';


$id_vehiculo = $_POST['id_vehiculo'];
$sql_patente = "SELECT patente FROM Vehiculo WHERE id_vehiculo = '$id_vehiculo'";

$result = $conn->query($sql_patente);
$vehiculo = $result->fetch_assoc();
$patente = $vehiculo['patente'];

$sql = "DELETE FROM vehiculo WHERE id_vehiculo = '$id_vehiculo'";
if ($conn->query($sql) === TRUE) {
    // Registrar la acción en el historial
    $usuario = $_SESSION['nombre']. ' ' .$_SESSION['apellidoP'];
    $sql_historial = "INSERT INTO historial (id_vehiculo,patente_vehiculo, accion, usuario) VALUES ('$id_vehiculo','$patente', 'eliminado', '$usuario')";
    $conn->query($sql_historial);

    echo 'success';
} else {
    echo 'error';
}

$conn->close();
?>