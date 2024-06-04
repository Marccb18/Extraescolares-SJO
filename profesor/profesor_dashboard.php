<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'PRO') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['logout'])) {
    require_once('../config/logout.php');
    logout();
}
$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$showMaterias = $db->query("SELECT * FROM materia where ID_Profesor = '$_SESSION[id]'");
$materias = $showMaterias->fetchAll(PDO::FETCH_ASSOC);

$db = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor Dashboard</title>
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
            <li class="active">
                <a href="profesor_dashboard.php">
                    <img src="../assets/img/icon-home.svg" alt="Home icon">
                    Inicio
                </a>
            </li>
            <li>
                <a href="profesor_dashboard_alumnos.php">
                    <img src="../assets/img/Vector.svg" alt="Students icon">
                    Alumnos
                </a>
            </li>
            <li>
                <a href="profesor_sesiones.php">
                    <img src="../assets/img/library.svg" alt="Library icon">
                    Sesiones
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
                                <div div style="display: flex;  align-items: center;" >
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
                        <a href="profesor_dashboard.php">Clases</a>
                    </li>
                    <li>
                        <a href="profesor_dashboard_alumnos.php">Alumnos</a>
                    </li>
                </ul>
                <a href="select_pasar_lista.php" id="top-button">
                    <img src="../assets/img/plus-circled.svg" alt="Pasar Lista">
                    Pasar Lista
                </a>
            </div>
            <div id="title">
                <h3>Inicio</h3>
                <p>Busca entre todas tus clases</p>
            </div>
            <div id="filter">
                <div id="clases">
                    <p>Clases</p>
                    <div class="select-container">
                        <select class="select-filter" name="clases">
                            <option value="">Todas</option>
                            <?php
                            foreach ($materias as $materia) { ?>
                                <option value="<?= $materia['Nombre'] ?>"><?= $materia['Nombre'] ?></option>
                            <?php } ?>
                        </select>
                        <img src="../assets/img/arrow-select.svg" alt="Arrow Select">
                    </div>
                </div>
                <div id="fecha">
                    <p>Fecha</p>
                    <div id="date-container">
                        <img src="../assets/img/Calendar.svg" alt="Calendar">
                        <input type="date">
                    </div>
                </div>
            </div>
            <div id="main-content">
                <?php
                foreach ($materias as $materia) { ?>
                    <a class="item" href="show_materia.php?id=<?= $materia['ID'] ?>">
                        <img src="../assets/img/logoSJO.svg" alt="logo">
                        <p class="itemtitle"><?= $materia['Nombre'] ?></p>
                        <p class="itemsub"><?php
                                            switch ($materia['Dia']) {
                                                case 'LUN':
                                                    echo 'Lunes ';
                                                    break;
                                                case 'MAR':
                                                    echo 'Martes ';
                                                    break;
                                                case 'MIE':
                                                    echo 'Miércoles ';
                                                    break;
                                                case 'JUE':
                                                    echo 'Jueves ';
                                                    break;
                                                case 'VIE':
                                                    echo 'Viernes ';
                                                    break;
                                                case 'SAB':
                                                    echo 'Sábado ';
                                                    break;
                                                case 'DOM';
                                                    echo 'Domingo ';
                                                    break;
                                            } ?>
                            ·
                            <?= date('H:i', strtotime($materia['Hora'])) ?>
                        </p>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
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
        <form action="profesor_dashboard.php" method="post">
            <button type="submit" name="logout">
                <img src="../assets/img/logout.svg" alt="logout-icon">
            </button>
        </form>
    </div>
<script src="../assets/js/index.js"></script>

</html>