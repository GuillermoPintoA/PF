<?php


$host = 'localhost'; // Nombre del servidor de la base de datos
$dbname = 'login_system'; // Nombre de la base de datos
$user = 'root'; // Nombre de usuario de la base de datos
$password = ''; // Contraseña de la base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
$conexion=new mysqli("localhost","root","","login_system");

?>
