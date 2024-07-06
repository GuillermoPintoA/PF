<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Validación y procesamiento de la subida de archivo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    // Validar campos y procesar archivo
    $patente = $_POST['patente'];
    $id_comprado = $_POST['id_comprado'];
    $nombre_archivo = basename($_FILES['archivo']['name']);
    $ruta_archivo = 'uploads/' . $nombre_archivo;
    $tipo_archivo = pathinfo($ruta_archivo, PATHINFO_EXTENSION);

    // Validar tipo de archivo
    $tipos_permitidos = ['pdf', 'png', 'jpg'];
    if (!in_array($tipo_archivo, $tipos_permitidos)) {
        echo "Tipo de archivo no permitido.";
        exit();
    }

    // Mover el archivo a la carpeta de uploads
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)) {
        // Redirigir de vuelta a agregar_vehiculo.php con parámetros
        header("Location: agregar_vehiculo.php?patente=$patente&id_comprado=$id_comprado&nombre_archivo=$nombre_archivo&ruta_archivo=$ruta_archivo&tipo_archivo=$tipo_archivo");
        exit();
    } else {
        echo "Error al mover el archivo.";
    }
}
?> 
