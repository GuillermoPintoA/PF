<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidoP = $_POST['apellidoP'];
    $apellidoM = $_POST['apellidoM'];
    $cargo = $_POST['cargo'];
    $mail = $_POST['mail'];
    $claveweb = $_POST['claveweb'];
    $rut = $_POST['rut'];
    $dv_rut = $_POST['dv_rut'];
    $fechacreacion = date("Y-m-d H:i:s");

    $sql = "INSERT INTO usuario (nombre, apellidoP, apellidoM, cargo, mail, fechacreacion, claveweb, rut, dv_rut)
            VALUES ('$nombre', '$apellidoP','$apellidoM', '$cargo', '$mail', '$fechacreacion', '$claveweb', '$rut', '$dv_rut')";

    if ($conn->query($sql) === TRUE) {
        header("Location: welcome.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<script>
        function validateForm() {
            const nombre = document.getElementById('nombre').value;
            const apellidoPaterno = document.getElementById('apellido_paterno').value;
            const apellido = document.getElementById('apellido').value;
            const cargo = document.getElementById('cargo').value;
            const mail = document.getElementById('mail').value;
            const claveweb = document.getElementById('claveweb').value;
            const rut = document.getElementById('rut').value;
            const dv_rut = document.getElementById('dv_rut').value;

            if (!nombre || !apellidoPaterno || !apellido || !cargo || !mail || !claveweb || !rut || !dv_rut) {
                alert('Todos los campos son obligatorios');
                return false;
            }

            if (!/^[0-9]{7,8}$/.test(rut)) {
                alert('El RUT debe tener entre 7 y 8 números y no contener letras');
                return false;
            }

            return true;
        }
    </script>
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
    <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
         &nbsp;
        <label for="apellidoP">Apellido Paterno:</label>&nbsp;
        <input type="text" id="apellidoP" name="apellidoP" required><br><br>
        <label for="apellidoM">Apellido Materno:</label>
        <input type="text" id="apellidoM" name="apellidoM" required><br><br>
        <label for="mail">Email:</label>
        <input type="email" id="mail" name="mail" required><br><br>&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="claveweb">Contraseña:</label>
        <input type="password" id="claveweb" name="claveweb" required><br><br>
        <label for="rut">RUT:</label>
        <input style='width: 10ch; display: inline-block;' type="text" id="rut" name="rut" required pattern="[0-9]{7,8}" maxlength="8">-

        <label for="dv_rut"></label>
        <input style='width: 2ch; display: inline-block;' type="text" id="dv_rut" name="dv_rut" required maxlength="1"><br><br>

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
