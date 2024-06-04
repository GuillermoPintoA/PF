<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_vehiculo = $_POST['id_vehiculo'];

    $sql = "DELETE FROM vehiculos WHERE id_vehiculo = $id_vehiculo";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
?>