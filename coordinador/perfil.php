<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'COO') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['logout'])) {
    require_once('../config/logout.php');
    logout();
}

$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$showPerfil = $db->query("SELECT * FROM personal where DNI = '$_SESSION[id]'");
$perfil = $showPerfil->fetchAll(PDO::FETCH_ASSOC);
$db = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="icon" href="../assets/img/logoSJO-fav.svg">
    <title>Perfil || <?php echo $perfil[0]['Nombre'] ?></title>
</head>

<body>
    <div id="aside">
        <div id="titlelogo">
            <img src="../assets/img/logoSJO.svg" alt="Logo SJO">
            <p>Sant Josep Obrer</p>
        </div>
        <ul id="side-menu">
            <li>
                <a href="./coord_dashboard.php">
                    <img src="../assets/img/icon-home.svg" alt="Home icon">
                    Inicio
                </a>
            </li>
            <li>
                <a href="./gestion_users.php">
                    <img src="../assets/img/Vector.svg" alt="Students icon">
                    Usuarios
                </a>
            </li>
            <li>
            <a href="./coordinador_sesiones.php">
                    <img src="../assets/img/library.svg" alt="Library icon">
                    Sesiones
                </a>
            <li>
                <a href="./gestion_materias.php">
                    <img src="../assets/img/layout-grid.svg" alt="Layout icon">
                    Materias
                </a>
            </li>
        </ul>
        <div>
            <div class="user-info-container" id="user-info-container">
                <div class="user-info">
                    <img src="../assets/img/logoSJO.svg" alt="Logo Sant Josep">
                    <p><?php echo $_SESSION['username'] ?></p>
                </div>
                <img src="../assets/img/arrow-select.svg" alt="Vector img" class="vector-img">
            </div>
            <div class="optionsProfile" id="optionsProfile">
                <ul>
                    <li>
                        <a href="./perfil.php" style="pointer-events: none;">
                            <div style="display: flex;  align-items: center;">
                                <img src="../assets/img/person.svg" alt="" style="margin-right: 6px;">
                                Ver Perfil
                            </div>
                            <img src="../assets/img/chevron-right.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <form action="perfil.php" method="post">
                            <button type="submit" name="logout">
                                <div div style="display: flex;  align-items: center;">
                                    <img src="../assets/img/logout.svg" alt="" style="margin-right: 6px;">
                                    Cerrar Sesión
                                </div>
                                <img src="../assets/img/chevron-right.svg" alt="">
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main">
        <div id="content">
            <h3>Cuenta</h3>
            <p>Perfil de <?php echo $perfil[0]['Nombre'] ?></p>
            <div id="main-content">
                <form action="edit_perfil.php?id=<?php echo $perfil[0]['DNI'] ?>" method="post">
                    <p>Nombre</p>
                    <input type="text" value="<?php echo $perfil[0]['Nombre'] ?>" disabled>
                    <p>Apellido</p>
                    <input type="text" value="<?php echo $perfil[0]['Apellidos'] ?>" disabled>
                    <p>Email</p>
                    <input type="email" value="<?php echo $perfil[0]['Email'] ?>" disabled>
                    <p>Telefono</p>
                    <input type="number" value="<?php echo $perfil[0]['Telefono'] ?>" disabled>
                    <p>Rol</p>
                    <input type="text" value="<?php echo $perfil[0]['ROL'] ?>" disabled>
                    <p>Contraseña</p>
                    <input type="password" value="<?php echo $perfil[0]['Password'] ?>" disabled>
                    <input type="hidden" name="perfil" value="perfil">
                    <input type="submit" value="Editar" id="edit">
                    <script>
                        console.log(<?php echo json_encode($perfil) ?>)
                    </script>
                </form>
            </div>
        </div>
    </div>
<div id="mobile-menu">
        <a href="./coord_dashboard.php">
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./gestion_users.php">
            <img src="../assets/img/Vector.svg" alt="gestion-users-icon">
        </a>
        <a href="./gestion_materias.php">
            <img src="../assets/img/layout-grid.svg" alt="gestion-materias-icon">
        </a>
        <a href="./perfil.php" class="active">
            <img src="../assets/img/person.svg" alt="person-icon">
        </a>
        <form action="perfil.php" method="post">
            <button type="submit" name="logout">
                <img src="../assets/img/logout.svg" alt="logout-icon">
            </button>
        </form>
    </div>
<script src="../assets/js/index.js"></script>

</html>