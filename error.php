<?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
    } else {
        $error = "Error desconocido";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <h1>Error</h1>
    <p>Ocurrió un error durante la conexión a la base de datos:</p>
    <p><?php echo $error; ?></p>
    <a href="./index.php">Volver al inicio</a>
</body>
</html>