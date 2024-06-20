<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $mail = $_POST['mail'];
    $claveweb = $_POST['claveweb'];
    $rut = $_POST['rut'];
    $dv_rut = $_POST['dv_rut'];
    $fechacreacion = date("Y-m-d H:i:s");

    $sql = "INSERT INTO usuario (nombre, apellido, cargo, mail, fechacreacion, claveweb, rut, dv_rut)
            VALUES ('$nombre', '$apellido', '$cargo', '$mail', '$fechacreacion', '$claveweb', '$rut', '$dv_rut')";

    if ($conn->query($sql) === TRUE) {
        header("Location: welcome.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver reportes</title>
    <script src="https://kit.fontawesome.com/568b99fb45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <!-- Incluye jQuery y DataTables CSS y JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <!-- Incluye el archivo de idioma español -->
    <script type="text/javascript" charset="utf8" src="Spanish.json"></script>
</head> 
<body>

    <div id="mySidenav" class="sidenav">
 
    <div class="user-info">
    <a href="perfil.php">
            <img  src="../img/user-icon.png" alt="User Icon" onclick="perfil.php"></a>
            <p><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ; ?></p>  
        
        </div>
        <a href="javascript:void(0)" class="" onclick="closeNav()"></a>

        <a href="welcome.php">Listado</a>
        <a href="historial.php">Historial</a>
        <?php if ($_SESSION['cargo'] == 'Administrador') { ?>
            <a href="agregar_usuario.php">Agregar usuario</a>
        <?php } ?>
        <a href="ver_reporte.php">Reporte</a>
        <a href="logout.php">Salir</a>
    </div>
    </div>
        <div id="main">         
<h1>Registrar Usuario</h1>
<div class="container mt-5">
    <div class="card">
    <form method="post" action="agregar_usuario.php">
        <label for="nombre">Nombre:<n></n></label> 
        <input style='width: 25ch; display: inline-block;' type="text" id="nombre" name="nombre" required> &nbsp;
        <label for="apellido">Apellido:</label>
        <input style='width: 25ch; display: inline-block;' type="text" id="apellido" name="apellido" required><br><br>
        <label for="mail">Email:</label>
        <input style='width: 25ch; display: inline-block;' type="email" id="mail" name="mail" required>&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="claveweb">Contraseña:</label>
        <input style='width: 25ch; display: inline-block;' type="password" id="claveweb" name="claveweb" required><br><br>
        <label  for="rut">RUT:</label>
        <input style='width: 8ch; display: inline-block;' type="text" id="rut" name="rut" required>-
        <label for="dv_rut"></label>
        <input style='width: 1ch; display: inline-block;' type="text" id="dv_rut" name="dv_rut"  required>
        <label for="rol">Cargo:</label>
        <select id="rol" name="Cargo">
            <option value="admin">Administrador</option>
            <option value="usuario">Gerente</option>
            <option value="usuario">Técnico</option>
            <option value="usuario">Empleado</option>
        </select><br><br><br><br>
        <input type="submit" value="Registrar">
    </form>
    </div>
    </div>
</body>
</html>
