<?php
session_start();
include 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Verificar si la clave id_vehiculo está presente en $_POST
if (isset($_POST['id_vehiculo'])) {
    $id_vehiculo = $_POST['id_vehiculo'];

    // Eliminar el vehículo de la base de datos
    $sql = "DELETE FROM Vehiculo WHERE id_vehiculo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_vehiculo);

    if ($stmt->execute()) {
        echo "Vehículo eliminado correctamente.";
    } else {
        echo "Error al eliminar el vehículo: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID de vehículo no especificado.";
}

$conn->close();
?>
