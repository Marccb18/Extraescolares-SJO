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

$user_id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['perfil']) {
        $origin = 'perfil';
    } else {
        $origin = 'edit_perfil';
    }
} else {
    $origin = 'edit_perfil';
}

$query = $db->prepare('SELECT * FROM personal WHERE DNI = ?');
$query->execute([$user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);
$db = null;

if ($_SESSION['id'] != $user_id) {
    header('Location: ../index.php');
    exit();
}

function comprobarOpcion($v, $user)
{
    if ($v == $user['ROL']) {
        echo 'selected';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="icon" href="../assets/img/logoSJO-fav.svg">

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
                        <a href="./perfil.php">
                            <div style="display: flex;  align-items: center;">
                                <img src="../assets/img/person.svg" alt="" style="margin-right: 6px;">
                                Ver Perfil
                            </div>
                            <img src="../assets/img/chevron-right.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <form action="profesor_dashboard.php" method="post" id="logout-form">
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
            <div id="topcontent">
                <div id="title" style="border: none; padding: 0;">
                    <h3>Editar usuario</h3>
                    <p>Edita al usuario <?= $user['Nombre'] . ' ' . $user['Apellidos'] ?></p>
                </div>
            </div>
            <div id="main-content">
                <form action="update_user.php" method="post">
                    <input type="hidden" name="dni" value="<?= $user['DNI'] ?>">
                    <p>Nombre</p>
                    <input type="text" name="nombre" value="<?= $user['Nombre'] ?>">
                    <p>Apellidos</p>
                    <input type="text" name="apellidos" value="<?= $user['Apellidos'] ?>">
                    <p>Email</p>
                    <input type="email" name="email" value="<?= $user['Email'] ?>">
                    <p>Contraseña</p>
                    <input type="text" name="password" value="<?= $user['Password'] ?>">
                    <p>Teléfono</p>
                    <input type="number" name="telefono" id="telefono" value="<?= $user['Telefono'] ?>">
                    <p>Rol</p>
                    <input type="hidden" name="origin" value="<?= $origin ?>" disabled>
                    <div class="form-select">
                        <select name="rol" id="rol_id" disabled>
                            <option value="PRO" <?php comprobarOpcion('PRO', $user) ?>>Profesor</option>
                            <option value="COO" <?php comprobarOpcion('COO', $user) ?>>Coordinador</option>
                            <option value="ADM" <?php comprobarOpcion('ADM', $user) ?>>Administrador</option>
                        </select>
                        <img src="../assets/img/arrow-select.svg" alt="">
                    </div>
                    <input type="submit" value="Confirmar">
                </form>
            </div>
        </div>
    </div>
    <div id="mobile-menu">
        <a href="./coord_dashboard.php">
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./gestion_users.php" class="active">
            <img src="../assets/img/Vector.svg" alt="gestion-users-icon">
        </a>
        <a href="./coordinador_sesiones.php">
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