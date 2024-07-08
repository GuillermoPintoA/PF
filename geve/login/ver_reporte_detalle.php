<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$id_reporte = $_GET['id_reporte'];

$sql = "SELECT r.*, v.patente AS nombre_vehiculo FROM reporte r JOIN Vehiculo v ON r.id_vehiculo = v.id_vehiculo WHERE r.id_reporte = $id_reporte";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $reporte = $result->fetch_assoc();
} else {
    echo "Reporte no encontrado.";
    exit();
}

$conn->close();
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
    <div class="container">
        <h2>Reporte de Vehículo</h2>
        <div class="card"> 
        <p><strong>Vehículo:</strong> <?php echo $reporte['nombre_vehiculo']; ?> &nbsp;&nbsp;&nbsp;
        <strong>Fecha del Reporte:</strong> <?php echo $reporte['fecha_reporte']; ?></p>
        <p><strong>Descripción:</strong></p>
        <p><?php echo $reporte['descripcion']; ?></p>
    </div>
    </div>
    </div>
</body>
</html>
