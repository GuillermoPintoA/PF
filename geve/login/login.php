<?php
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el username es email o rut
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        // username es un email
        $sql = "SELECT * FROM usuario WHERE mail = '$username' AND claveweb = '$password'";
    } else {
        // username es un rut
        $sql = "SELECT * FROM usuario WHERE rut = '$username' AND claveweb = '$password'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['nombre'];
        $_SESSION['cargo'] = $row['cargo'];
        header("Location: welcome.php");
        exit();
    } else {
        $error = "Nombre de usuario o contraseña incorrectos";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesion</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="login-container">
        <form action="login.php" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Email o RUT:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="Login">
            <span><?php echo $error; ?></span>
        </form>
    </div>
</body>
</html>
