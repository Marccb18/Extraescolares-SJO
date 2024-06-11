<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['logout'])) {
    require_once('../config/logout.php');
    logout();
}

$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$showUsers = $db->query("SELECT * FROM personal ORDER BY Apellidos");
$showUsers = $showUsers->fetchAll(PDO::FETCH_ASSOC);
$db = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
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
                <a href="./admin_dashboard.php">
                    <img src="../assets/img/icon-home.svg" alt="Home icon">
                    Inicio
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <img src="../assets/img/Vector.svg" alt="Students icon">
                    Usuarios
                </a>
            </li>
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
                                <img src="../assets/img/person.svg" alt="" style="margin-right: 6px; font-size: 0.85rem">
                                Ver Perfil
                            </div>
                            <img src="../assets/img/chevron-right.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <form action="gestion_users.php" method="post">
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
            <div id="top-content">
                <ul>
                    <li class="active">
                        <a href="./gestion_users.php">Usuarios</a>
                    </li>
                    <li>
                        <a href="./gestion_alumnos.php">Alumnos</a>
                    </li>
                </ul>

                <form action="import_alumnos.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="file" accept=".csv">
                    <button type="submit">Importar Alumnos</button>
                </form>



                <a href="./new_user.php" id="button-top">
                    <img src="../assets/img/plus-circled.svg" alt="Pasar Lista">
                    Añadir Usuario
                </a>
            </div>
            <div id="title">
                <h3>Usuarios</h3>
                <p>Busca entre todos los usuarios</p>
            </div>
            <div class="main-content">
                <table id="table-desktop">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Rol</th>
                        <th class="th-buttons">Editar</th>
                        <th class="th-buttons">Eliminar</th>
                    </tr>
                    <?php foreach ($showUsers as $user) { ?>
                        <tr>
                            <td>
                                <p>
                                    <img src="../assets/img/user.svg" alt="user">
                                    <?= $user['Nombre'] ?>
                                </p>
                            </td>
                            <td><?= $user['Apellidos'] ?></td>
                            <td>
                                <?php
                                switch ($user['ROL']) {
                                    case 'PRO':
                                        echo 'Profesor';
                                        break;

                                    case 'COO':
                                        echo 'Coordinador';
                                        break;

                                    case 'ADM':
                                        echo 'Administrador';
                                        break;
                                }
                                ?>
                            </td>
                            <td><a style="background-color: #000;" class="button-table" href="edit_user.php?id=<?= $user['DNI'] ?>"><img src="../assets/img/pen.svg" alt="">Editar</a></td>
                            <td style="padding-right: 0"><a class="button-table" href="delete_user.php?id=<?= $user['DNI'] ?>"><img src="../assets/img/trash.svg" alt="">Eliminar</a></td>
                        </tr>
                    <?php } ?>
                </table>
                <div id="table-mobile">
                    <input type="search" style="margin-bottom: 10px;" name="" id="search" placeholder="Buscar...">
                    <?php foreach ($showUsers as $user) { ?>
                        <details id="details-desplegable">
                            <summary class="materis">
                                <img src="../assets/img/arrow-select.svg" alt="">
                                <p><?= $user['Nombre'] . ' ' . $user['Apellidos'] ?></p>
                            </summary>
                            <div class="details-content">
                                <p>
                                    Rol: <?php
                                            switch ($user['ROL']) {
                                                case 'PRO':
                                                    echo 'Profesor';
                                                    break;

                                                case 'COO':
                                                    echo 'Coordinador';
                                                    break;

                                                case 'ADM':
                                                    echo 'Administrador';
                                                    break;
                                            }
                                            ?>
                                </p>
                                <div>
                                    <a style="background-color: #000;" class="button-table" href="edit_user.php?id=<?= $user['DNI'] ?>"><img src="../assets/img/pen.svg" alt="">Editar</a>
                                    <a class="button-table" href="delete_user.php?id=<?= $user['DNI'] ?>"><img src="../assets/img/trash.svg" alt="">Eliminar</a>
                                </div>
                            </div>
                        </details>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="mobile-menu">
        <a href="./admin_dashboard.php">
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./gestion_users.php" class="active">
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