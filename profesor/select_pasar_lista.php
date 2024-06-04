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
function getDayOfWeek()
{

    $dayOfWeek = date('w');

    $spanishDays = array("dom", "lun", "mar", "mie", "jue", "vie", "sab");

    if ($dayOfWeek >= 0 && $dayOfWeek <= 6) {
        return strtoupper($spanishDays[$dayOfWeek]);
    } else {
        return "ERR";
    }
}
$day = getDayOfWeek();
$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = $db->prepare("SELECT * FROM materia where ID_Profesor = '$_SESSION[id]' and Dia = :dia ORDER BY Hora ASC");
$query->bindParam(':dia', $day);
$query->execute();
$materias = $query->fetchAll(PDO::FETCH_ASSOC);

$db = null;
$cantidad_materias = count($materias);
if ($cantidad_materias == 1) {
    $id_materia = $materias[0]['ID'];
    header("Location: pasar_lista.php?id=$id_materia");
    exit();
}

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
                <a href="#">
                    <img src="../assets/img/Vector.svg" alt="Students icon">
                    Alumnos
                    
                </a>
            </li>
            <li>
                <a href="#">
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
                        <form action="gestion_materias.php" method="post">
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
            </div>
            <div id="title">
                <h3>Tus clases de hoy: <?php echo getDayOfWeek() ?> </h3>
                <p>Escoge una clase para pasar lista</p>
            </div>
            <div class="main-content">
                <?php
                $count = 0;
                foreach ($materias as $materia) {
                    if ( $materia['Dia'] == getDayOfWeek()) {
                        $count++; ?>
                        <a class="item" href="pasar_lista.php?id=<?= $materia['ID'] ?>">
                            <img src="../assets/img/logoSJO.svg" alt="logo">
                            <p class="itemtitle"><?= $materia['Nombre'] ?></p>
                            <p class="itemsub">
                                <?= $materia['Dia'] ?>
                                <?= date('H:i', strtotime($materia['Hora'])) ?>
                            </p>
                        </a>
                <?php }
                }
                if ($count == 0) {
                    echo '<h2>no hay materias hoy</h2>';
                }
                ?>
            </div>
        </div>
    </div>
<div id="mobile-menu">
        <a href="./admin_dashboard.php" >
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./gestion_users.php">
            <img src="../assets/img/Vector.svg" alt="gestion-users-icon">
        </a>
        <a href="./gestion_materias.php" class="active">
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

</html>