<?php
session_start();
include 'db.php';

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['username']) || $_SESSION['cargo'] !== 'admin') {
    header("Location: welcome.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidoP = $_POST['apellidoP'];
    $apellidoM = $_POST['apellidoM'];
    $cargo = $_POST['cargo'];
    $mail = $_POST['mail'];
    $claveweb = $_POST['claveweb'];
    $rut = $_POST['rut'];
    $dv_rut = $_POST['dv_rut'];
    $fechacreacion = date('Y-m-d');

    $sql = "INSERT INTO usuario (nombre, apellidoP, apellidoM, cargo, mail, fechacreacion, claveweb, rut, dv_rut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $nombre, $apellidoP, $apellidoM, $cargo, $mail, $fechacreacion, $claveweb, $rut, $dv_rut);

    if ($stmt->execute()) {
        echo "Usuario agregado correctamente.";
        header("Location: welcome.php");
    } else {
        echo "Error al agregar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
