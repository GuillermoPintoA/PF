<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_vehiculo = $_POST['id_vehiculo'];
    $descripcion = $_POST['descripcion'];
    $id_motivo = $_POST['id_motivo'];
    $fecha_reporte = date("Y-m-d");

    $sql = "INSERT INTO reporte (id_vehiculo, id_motivo, fecha_reporte, descripcion) VALUES ('$id_vehiculo', '$id_motivo', '$fecha_reporte', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        $success = "Reporte generado con éxito.";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener la lista de vehículos
$vehiculos_sql = "SELECT id_vehiculo,patente FROM Vehiculo";
$vehiculos_result = $conn->query($vehiculos_sql);

// Obtener la lista de motivos
$motivos_sql = "SELECT id_motivo, nombre FROM motivo";
$motivos_result = $conn->query($motivos_sql);

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
<div id="main">

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
        <h2>Generar Reporte</h2>
        <div class="card">
        <?php if (isset($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="post" action="generar_reporte.php">
            <label for="id_vehiculo">Seleccionar Vehículo:</label>
            <select id="id_vehiculo" name="id_vehiculo" required>
                <?php while($row = $vehiculos_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_vehiculo']; ?>"><?php echo $row['patente']; ?> </option>
                <?php } ?>
            </select><br>
            <label for="id_motivo">Seleccionar Causa:</label>
            <select id="id_motivo" name="id_motivo" required>
                <?php while($row2 = $motivos_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row2['id_motivo']; ?>"><?php echo $row2['nombre']; ?></option>
                <?php } ?>
            </select><br>>
            <label for="descripcion">Descripción del Reporte:</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50" required></textarea><br><br>
            <input type="submit" value="Generar Reporte">
            
        </form>
    </div>
    </div></div>
</body>
</html>
