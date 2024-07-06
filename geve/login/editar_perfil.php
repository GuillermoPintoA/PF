<?php
session_start();
include 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: perfil.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM usuario WHERE mail = ? OR rut = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $claveweb = password_hash($_POST['claveweb'], PASSWORD_BCRYPT);

    $sql_update = "UPDATE usuario SET claveweb = ? WHERE idusuario = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $claveweb, $user['idusuario']);

    if ($stmt_update->execute()) {
        header("Location: cambiar_contrasena.php?success=1");
        exit();
    } else {
        echo "Error al actualizar el perfil: " . $stmt_update->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Editar Perfil</h2>
    <form method="POST">

        <label for="claveweb">Nueva Contraseña:</label>
        <input type="password" id="claveweb" name="claveweb" required><br>

        <button type="submit">Actualizar Perfil</button>
    </form>
</body>
</html>
