<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_vehiculo'])) {
    $id_vehiculo = $_GET['id_vehiculo'];

    // Obtener el nombre del vehículo antes de eliminarlo
    $sql_vehiculo = "SELECT patente FROM Vehiculo WHERE id_vehiculo = ?";
    $stmt_vehiculo = $conn->prepare($sql_vehiculo);
    $stmt_vehiculo->bind_param("i", $id_vehiculo);
    $stmt_vehiculo->execute();
    $result_vehiculo = $stmt_vehiculo->get_result();
    $vehiculo = $result_vehiculo->fetch_assoc();
    $patente_vehiculo = $vehiculo['patente'];
    $stmt_vehiculo->close();

    // Eliminar el vehículo
    $sql = "DELETE FROM Vehiculo WHERE id_vehiculo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_vehiculo);
    if ($stmt->execute()) {
        // Registrar la eliminación en el historial
        $usuario = $_SESSION['username'];
        $accion = "Eliminado";
        $descripcion = "Vehículo '$patente_vehiculo' eliminado por $usuario";
        $sql_historial = "INSERT INTO Historial (id_vehiculo, patente_vehiculo, accion, usuario, fecha) VALUES (?, ?, ?, ?, NOW())";
        $stmt_historial = $conn->prepare($sql_historial);
        $stmt_historial->bind_param("isss", $id_vehiculo, $patente_vehiculo, $accion, $usuario);
        $stmt_historial->execute();
        $stmt_historial->close();
    }

    $stmt->close();
}

$conn->close();

header("Location: welcome.php");
exit();
?>
