<?php
if (!isset($_GET['success']) || $_GET['success'] != 1) {
    header("Location: perfil.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contraseña Cambiada</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <style>
        .confirmation {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .tick {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #4CAF50;
            position: relative;
            animation: tickAnimation 1s ease-in-out;
        }

        .tick::after {
            content: "";
            position: absolute;
            left: 25px;
            top: 45px;
            width: 20px;
            height: 45px;
            border: solid white;
            border-width: 0 10px 10px 0;
            transform: rotate(45deg);
        }

        @keyframes tickAnimation {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="confirmation">
        <div class="tick"></div>
        <h1>Contraseña Cambiada</h1>
        <p>Su contraseña ha sido cambiada exitosamente.</p>
        <a href="perfil.php">Regresar</a>
    </div>
</body>
</html>
