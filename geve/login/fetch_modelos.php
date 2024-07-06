<?php
include 'db.php';

if (isset($_GET['id_marca'])) {
    $id_marca = $_GET['id_marca'];
    $sql = "SELECT id_modelo, nombre FROM Modelo WHERE id_marca = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_marca);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<option value=''>Seleccione un modelo</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id_modelo']}'>{$row['nombre']}</option>";
    }
}
?>
