<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

// Extraer datos de la tabla vehiculos
$sql_tipo1 = "SELECT * FROM vehiculo ";
$result_tipo1 = $conn->query($sql_tipo1);

$sql_tipo2 = "SELECT * FROM vehiculo ";
$result_tipo2 = $conn->query($sql_tipo2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio</title>
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


    <a href="agregar_vehiculo.php" class="add-btn">Agregar Vehículo</a>

   <br>
   <div class="card">
            <h2>Lista de Autos</h2>
            <table id="autosTable" class="display">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                        <th>Patente</th>
                        <th>Marca</th>
                        <th>Año</th>
                        <th>Prox Revision</th>
                        <th>Prox Permiso Circulacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_tipo1->num_rows > 0) {
                        while($row = $result_tipo1->fetch_assoc()) {
                            echo "<tr>
                            <td>{$row['id_vehiculo']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['identificador']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['ano']}</td>
                            <td>{$row['vencimientoRevision']}</td>
                            <td>{$row['vencimientoPermisoCirculacion']}</td>
                                <td> 

                                    <span class='action-icon view-icon' onclick='viewVehicle({$row['id_vehiculo']})'>&#128065;</span>
                                    <span class='action-icon edit-icon' onclick='editVehicle({$row['id_vehiculo']})'>&#9998;</span>
                                    <span class='action-icon delete-icon' onclick='deleteVehicle({$row['id_vehiculo']})'>&#128465;</span>
                                   
                                   
                                </td>
                                   </tr>";
                           
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay vehículos</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

   <br>

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
            $('#autosTable').DataTable({
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
        function confirmDelete(idVehiculo) {
    if (confirm("¿Está seguro de que desea eliminar este vehículo?")) {
        // Enviar la solicitud AJAX para eliminar el vehículo
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_vehiculo.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Manejar la respuesta del servidor
                alert(xhr.responseText); // Mostrar la respuesta del servidor
                // Actualizar la página u otra acción necesaria después de la eliminación
                location.reload(); // Recargar la página después de eliminar el vehículo
            }
        };
        xhr.send("id_vehiculo=" + idVehiculo);
    }
}
        function deleteVehicle1(id_vehiculo) {
            window.location.href = `eliminar_vehiculo1.php?id=${id_vehiculo}`;
        }
        function editVehicle(id_vehiculo) {
            window.location.href = `editar_vehiculo.php?id=${id_vehiculo}`;
        }
        function addDocuments(id_vehiculo) {
            window.location.href = `agregar_documentos.php?id=${id_vehiculo}`;
        }
        function viewVehicle(id_vehiculo) {
            window.location.href = `ver_vehiculo_detalle.php?id=${id_vehiculo}`;
        }
    </script>
</body>
</html>
