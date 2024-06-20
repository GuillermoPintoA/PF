<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ver_vehiculo_detalle.php?id_vehiculo=$id_vehiculo");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    $id_vehiculo = $_POST['id_vehiculo'];
    $archivo = $_FILES['archivo'];
    $nombre_archivo = basename($archivo['name']);
    $ruta_archivo = 'uploads/' . $nombre_archivo;
    $tipo_archivo = pathinfo($ruta_archivo, PATHINFO_EXTENSION);

    // Validar tipo de archivo
    $tipos_permitidos = ['pdf', 'png', 'jpg'];
    if (!in_array($tipo_archivo, $tipos_permitidos)) {
        echo "Tipo de archivo no permitido.";
        exit();
    }

    // Mover el archivo a la carpeta de uploads
    if (move_uploaded_file($archivo['tmp_name'], $ruta_archivo)) {
        // Insertar la información del documento en la base de datos
        $sql = "INSERT INTO Documento (id_vehiculo, nombre_archivo, ruta_archivo, tipo_archivo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $id_vehiculo, $nombre_archivo, $ruta_archivo, $tipo_archivo);

        if ($stmt->execute()) {
            header("Location: welcome.php");
        } else {
            echo "Error al subir el documento.";
        }

        $stmt->close();
    } else {
        echo "Error al mover el archivo.";
    }
}

$conn->close();
?>
