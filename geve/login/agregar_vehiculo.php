<?php
session_start();
include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patente = $_POST['patente'];
    $comprado = isset($_POST['comprado']) ? 1 : 0;
    $fechaIngreso = $_POST['fechaIngreso'];
    $observacion = $_POST['observacion'];
    $vencimientoRevision = $_POST['vencimientoRevision'];
    $vencimientoPermisoCirculacion = $_POST['vencimientoPermisoCirculacion'];
    $ano = $_POST['ano'];
    $nChasis = $_POST['nChasis'];
    $nMotor = $_POST['nMotor'];
    $nCarroceria = $_POST['nCarroceria'];
    $id_modelo = $_POST['id_modelo'];

    if (!preg_match("/^[A-Za-z]{2}[A-Za-z0-9]{2}[0-9]{2}$/", $patente)) {
        die("Error: La patente debe tener el formato correcto.");
    }


    $sql = "INSERT INTO Vehiculo (patente, comprado, fechaIngreso, observacion, vencimientoRevision, vencimientoPermisoCirculacion, ano, nChasis, nMotor, nCarroceria, id_modelo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sissssisssi", $patente, $comprado, $fechaIngreso, $observacion, $vencimientoRevision, $vencimientoPermisoCirculacion, $ano, $nChasis, $nMotor, $nCarroceria, $id_modelo);

        if ($stmt->execute()) {
            $last_id = $stmt->insert_id;
            echo "Nuevo vehículo agregado correctamente. ID del vehículo: $last_id";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la declaración: " . $conn->error;
    }}
$sql_marcas = "SELECT id_marca, nombre FROM Marca";
$result_marcas = $conn->query($sql_marcas);

$sql_comprado = "SELECT id_comprado, tipo FROM Comprado";
$result_comprado = $conn->query($sql_comprado);
?>
 

<!DOCTYPE html>

<html>
    
<head>
<script>
        function fetchModelos(id_marca) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_modelos.php?id_marca=' + id_marca, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('modelo').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }
    </script>
    <title>Agregar Vehículo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color:  #d73c3e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color:  #d73c3e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Agregar Vehículo</h2>
        <form method="POST" action="procesar_agregar_vehiculo.php" enctype="multipart/form-data">
        <label for="patente">Patente:</label>
        <input type="text" id="patente" name="patente" required pattern="[A-Za-z]{2}[A-Za-z0-9]{2}[0-9]{2}" title="La patente debe contener 2 letras y 2 números"><br>

        <label for="comprado">Comprado:</label>
        <select id="id_comprado" name="id_comprado" required>
        <?php
        if ($result_comprado->num_rows > 0) {
            while($row = $result_comprado->fetch_assoc()) {
                echo "<option value='{$row['id_comprado']}'>{$row['tipo']}</option>";
            }
        }
        ?>
    </select><br>

        <label for="fechaIngreso">Fecha de Ingreso:</label>
        <input type="date" id="fechaIngreso" name="fechaIngreso" required><br>

        <label for="observacion">Observación:</label>
        <textarea id="observacion" name="observacion"></textarea><br>

        <label for="vencimientoRevision">Vencimiento Revisión:</label>
        <input type="date" id="vencimientoRevision" name="vencimientoRevision" required><br>

        <label for="vencimientoPermisoCirculacion">Vencimiento Permiso Circulación:</label>
        <input type="date" id="vencimientoPermisoCirculacion" name="vencimientoPermisoCirculacion" required><br>

        <label for="ano">Año:</label>
        <input type="number" id="ano" name="ano" required><br>

        <label for="nChasis">Número de Chasis:</label>
        <input type="text" id="nChasis" name="nChasis" required><br>

        <label for="nMotor">Número de Motor:</label>
        <input type="text" id="nMotor" name="nMotor" required><br>

        <label for="nCarroceria">Número de Carrocería:</label>
        <input type="text" id="nCarroceria" name="nCarroceria" required><br>


        <label for="marca">Marca:</label>
        <select id="marca" name="id_marca" onchange="fetchModelos(this.value)" required>
            <option value="">Seleccione una marca</option>
            <?php while ($row_marca = $result_marcas->fetch_assoc()): ?>
                <option value="<?php echo $row_marca['id_marca']; ?>"><?php echo $row_marca['nombre']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="modelo">Modelo:</label>
        <select id="modelo" name="id_modelo" required>
            <option value="">Seleccione un modelo</option>
        </select><br>

  
        <button type="submit">Agregar Vehículo</button>
    </form>

    </div>
</body>
</html>