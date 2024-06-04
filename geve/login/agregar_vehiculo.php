<!DOCTYPE html>
<html>
<head>
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
        <h2>Agregar Vehículo</h2>
        <form action="procesar_agregar_vehiculo.php" method="POST">
        <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="n_chasis">N° Chasis:</label>
                <input type="text" id="n_chasis" name="n_chasis" required>
            </div>
            <div class="form-group">
                <label for="patente">Patente:</label>
                <input type="text" id="patente" name="patente" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>
            </div>
            <div class="form-group">
                <label for="tipo_vehiculo">Tipo Vehículo:</label>
                <select id="tipo_vehiculo" name="tipo_vehiculo" required>
                    <option value="1">Vehiculo</option>
                    <option value="2">Maquinaria</option>
                </select>
            </div>
            <input type="submit" value="Agregar Vehículo">
        </form>
    </div>
</body>
</html>