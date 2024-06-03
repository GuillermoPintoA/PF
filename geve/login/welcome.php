<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
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
  
            <img src="../img/user-icon.png" alt="User Icon">
            <p><?php echo $_SESSION['username']; ?></p>  
        
        </div>
        <a href="javascript:void(0)" class="" onclick="closeNav()"></a>

        <a href="welcome.php">Listado</a>
        <a href="#">Historial</a>
        <a href="#">Gastos</a>
        <a href="logout.php">Salir</a>
    </div>
    </div>
    <div id="main">


    <a href="agregar_vehiculo.php" class="add-btn">Agregar Vehículo</a>
        <div class="card">
            <h2>Lista de Autos</h2>
            <table id="autosTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Patente</th>
                        <th>Estado</th>
                        <th>Revisión Técnica</th>
                        <th>Permiso de Circulación</th>
                        <th>Próxima Mantención</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Auto A</td>
                        <td>ABC123</td>
                        <td>Activo</td>
                        <td>2024-05-01</td>
                        <td>2024-06-01</td>
                        <td>14000</td>
                        <td>
                            <button class="editbtn">Editar</button>
                            <button class="deletebtn">Eliminar</button>
                        </td>
                    </tr>
                    <!-- Puedes agregar más filas aquí -->
                </tbody>
            </table>
        </div>
   <br>
   <br>
    <div class="card">
            <h2>Lista de Maquinaria</h2>
            <table id="maquinariaTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Último Mantenimiento</th>
                        <th>Permiso de Circulación</th>
                        <th>Próxima Mantención</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Maquina A</td>
                        <td>Tipo 1</td>
                        <td>Activo</td>
                        <td>2024-04-15</td>
                        <td>2024-06-01</td>
                        <td>16000</td>
                        <td>
                            <button class="editbtn">Editar</button>
                            <button class="deletebtn">Eliminar</button>
                        </td>
                    </tr>
                    <!-- Puedes agregar más filas aquí -->
                </tbody>
            </table>
        </div>
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
    </script>
</body>
</html>