<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM vehiculos WHERE id_vehiculo = $id";
$result = $conn->query($sql);
$vehicle = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n_chasis = $_POST['n_chasis'];
    $patente = $_POST['patente'];
    $marca = $_POST['marca'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];

    $sql = "UPDATE vehiculos SET n_chasis='$n_chasis', patente='$patente', marca='$marca', tipo_vehiculo='$tipo_vehiculo' WHERE id_vehiculo=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: welcome.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Vehículo</title>
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
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Vehículo</h2>
        <form action="editar_vehiculo.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $vehicle['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="n_chasis">N° Chasis:</label>
                <input type="text" id="n_chasis" name="n_chasis" value="<?php echo $vehicle['n_chasis']; ?>" required>
            </div>
            <div class="form-group">
                <label for="patente">Patente:</label>
                <input type="text" id="patente" name="patente" value="<?php echo $vehicle['patente']; ?>" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" value="<?php echo $vehicle['marca']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo_vehiculo">Tipo Vehículo:</label>
                <select id="tipo_vehiculo" name="tipo_vehiculo" required>
                    <option value="1" <?php if ($vehicle['tipo_vehiculo'] == 1) echo 'selected'; ?>>Tipo 1</option>
                    <option value="2" <?php if ($vehicle['tipo_vehiculo'] == 2) echo 'selected'; ?>>Tipo 2</option>
                </select>
            </div>
            <input type="submit" value="Guardar Cambios">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
