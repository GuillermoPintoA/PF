<?php
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí puedes manejar la lógica de agregar documentos.
    // Esto puede incluir cargar archivos y guardar información en la base de datos.

    // Ejemplo de manejar la carga de archivos:
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es un documento permitido
    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        echo "Lo sentimos, solo se permiten archivos PDF, DOC y DOCX.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Guardar la ruta del archivo en la base de datos
            $sql = "INSERT INTO documentos (id_vehiculo, ruta_documento) VALUES ($id, '$target_file')";

            if ($conn->query($sql) === TRUE) {
                echo "El documento ha sido subido exitosamente.";
            } else {
                echo "Error al guardar el documento en la base de datos: " . $conn->error;
            }
        } else {
            echo "Lo sentimos, hubo un error al subir tu archivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Documentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="file"] {
            display: block;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Agregar Documentos para el Vehículo ID: <?php echo $id; ?></h2>
        <form action="agregar_documentos.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fileToUpload">Selecciona el documento para subir:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
            <input type="submit" value="Subir Documento" name="submit">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
