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
    <form action="index.php" method="post">
        <?php if ($error != "") { ?>
            <div style="color: red;"><?php echo $error; ?></div>
        <?php } ?>
        <label for="email">Email: </label>
        <input type="text" name="email" id="email"><br><br>
        <label for="password">Contraseña: </label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
<div id="mobile-menu">
        <a href="./admin_dashboard.php" class="active">
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./gestion_users.php">
            <img src="../assets/img/Vector.svg" alt="gestion-users-icon">
        </a>
        <a href="./gestion_materias.php">
            <img src="../assets/img/layout-grid.svg" alt="gestion-materias-icon">
        </a>
        <a href="./perfil.php">
            <img src="../assets/img/person.svg" alt="person-icon">
        </a>
        <form action="admin_dashboard.php" method="post">
            <button type="submit" name="logout">
                <img src="../assets/img/logout.svg" alt="logout-icon">
            </button>
        </form>
    </div>
<script src="../assets/js/index.js"></script>
</html>