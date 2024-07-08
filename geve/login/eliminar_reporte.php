<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_reporte'])) {
    $id_reporte = $_POST['id_reporte'];

    $sql = "DELETE FROM reporte WHERE id_reporte = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_reporte);

    if ($stmt->execute()) {
        echo "Reporte eliminado exitosamente.";
    } else {
        echo "Error al eliminar el reporte.";
    }

    $stmt->close();
}

$conn->close();
?>
