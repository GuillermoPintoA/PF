<?php
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Obtener la lista de reportes
$sql = "SELECT r.id_reporte, r.fecha_reporte, r.descripcion, v.nombre AS nombre_vehiculo, m.nombre AS motivo
        FROM reporte r
        JOIN Vehiculo v ON r.id_vehiculo = v.id_vehiculo
        JOIN motivo m ON r.id_motivo = m.id_motivo";
$result = $conn->query($sql);
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
    <script>
        $(document).ready( function () {
            $('#reportesTable').DataTable();
        } );
    </script>
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
    <a href="generar_reporte.php" class="add-btn">Generar Reporte</a>
        <h1>Lista de Reportes</h1>
        <div class="card"> 
        <?php if ($result->num_rows > 0) { ?>
            <table id="reportesTable" class="display">
                <thead>
                    <tr>
                        <th>ID Reporte</th>
                        <th>Vehículo</th>
                        <th>Fecha del Reporte</th>
                        <th>Descripción</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id_reporte']; ?></td>
                            <td><?php echo $row['nombre_vehiculo']; ?></td>
                            <td><?php echo $row['fecha_reporte']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['motivo']; ?></td>
                            
                            <td>
                            <a href="ver_reporte_detalle.php?id_reporte=<?php echo $row['id_reporte']; ?>">&#x1f441;</a>
                            <span class='action-icon delete-icon' onclick='deleteReporte({$row['id_reporte']})'>&#128465;</span>
                                
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No hay reportes disponibles.</p>
        <?php } ?>
    </div>

    <script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }

    $(document).ready(function() {
            $('#autosTable, #maquinariaTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                "rowCallback": function(row, data) {
                    var proximaMantencionIndex = $(row).find('td:eq(6)').index();
                    var proximaMantencion = parseInt(data[proximaMantencionIndex]);
                    var estadoIndex = $(row).find('td:eq(3)').index();
                    var estado = data[estadoIndex];
                    if (estado === 'Activo') {
                        $(row).find('td:eq(' + estadoIndex + ')').css('color', 'green');
                    } else if (estado === 'No Activo') {
                        $(row).find('td:eq(' + estadoIndex + ')').css('color', 'red');
                    }
                    if (proximaMantencion > 15000) {
                        $(row).find('td:eq(' + proximaMantencionIndex + ')').css('color', 'red');
                    } else if (proximaMantencion > 10000) {
                        $(row).find('td:eq(' + proximaMantencionIndex + ')').css('color', 'orange');
                    } else {
                        $(row).find('td:eq(' + proximaMantencionIndex + ')').css('color', 'green');
                    }
                }
            });
       
        // Abre el menú lateral al cargar la página
        openNav();
    });
    function deleteVehicle(id_vehiculo) {
            if (confirm("¿Estás seguro de que deseas eliminar este vehículo?")) {
                $.ajax({
                    url: 'eliminar_vehiculo.php',
                    type: 'POST',
                    data: { id_vehiculo: id_vehiculo },
                    success: function(response) {
                        if (response == 'success') {
                            alert("Vehículo eliminado exitosamente");
                            location.reload();
                        } else {
                            alert("Error al eliminar el vehículo");
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
