<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: perfil.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil del Usuario</title>

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
<div class="card"> 
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
        <h1>Perfil del Usuario</h1>
        <p><strong>Nombre:</strong> <?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellidoP']; ?></p>
        <p><strong>Cargo:</strong> <?php echo $_SESSION['cargo']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['username']; ?></p>
        <p><strong>RUT:</strong> <?php echo $_SESSION['rut'] . '-' . $_SESSION['dv_rut']; ?></p>
        <div class="confirmation">
        <div class="tick"></div>

        <a href="editar_perfil.php">Regresar</a>
    </div>
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
</body>
</html>
