<?php
require('./config/conexion.php');
require_once('./config/users_control.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="icon" href="./assets/img/logoSJO-fav.svg">
</head>
<body>
    <main>
        <form action="index.php" method="post">
            <span>
                <img src="./assets/img/logoSJO.svg" alt="logo-sjo">
                Sant Josep Obrer
            </span>
            <input type="text" name="email" id="email" placeholder="Email">
            <input type="password" id="password" name="password" placeholder="Contraseña">
            <input type="submit" value="Iniciar Sesión">
        </form>
    </main>
</body>
    <?php if ($error != "") { ?>
        <script src="./assets/js/error.js"></script>
    <?php } ?>
</html>