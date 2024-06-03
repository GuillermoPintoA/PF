<?php
session_start();

// Credenciales predefinidas
$valid_username = "Asmadeus";
$valid_password = "1";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>