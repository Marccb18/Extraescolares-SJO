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
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $materia_id = $_GET['id'];

    $query = $db->prepare('SELECT * FROM materia WHERE ID = :id');
    $query->bindParam(':id', $materia_id);
    $query->execute();
    $materia = $query->fetch(PDO::FETCH_ASSOC);

    $profesores = $db->query("SELECT * FROM personal WHERE ROL = 'PRO' ");
    $profesores = $profesores->fetchAll(PDO::FETCH_ASSOC);

    $query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia = :id');
    $query->bindParam(':id', $materia_id);
    $query->execute();
    $alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    function comprobarOption($v, $x) {
        if ($v == $x) {
            echo 'selected';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/logoSJO-fav.svg">
    <title>Editar Materia</title>
</head>
<body>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <a href="#">
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
                        <a href="">
                            <div style="display: flex;  align-items: center;">
                                <img src="../assets/img/person.svg" alt="" style="margin-right: 6px;">
                                Ver Perfil
                            </div>
                            <img src="../assets/img/chevron-right.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <form action="admin_dashboard.php" method="post" id="logout-form">
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
            <div id="topcontent">
                <div id="title" style="border: none; padding: 0;">
                    <h3>Editar Materia</h3>
                    <p>Edita la materia de <?= $materia['Nombre']?></p>
                </div>
            </div>
            <div id="main-content" style="flex-direction: column;">
                <form action="update_materia.php" method="post">
                    <input type="hidden" name="id" value=<?= $materia_id ?> >
                    <p>Nombre</p>
                    <input type="text" name="nombre" value="<?= $materia['Nombre'] ?>" id="nombre">
                    <p>Dia</p>
                    <div class="form-select">
                        <select name="dia" id="dia">
                            <option value="LUN" <?php comprobarOption('LUN', $materia['Dia']) ?> >Lunes</option>
                            <option value="MAR" <?php comprobarOption('MAR', $materia['Dia']) ?> >Martes</option>
                            <option value="MIE" <?php comprobarOption('MIE', $materia['Dia']) ?> >Miércoles</option>
                            <option value="JUE" <?php comprobarOption('JUE', $materia['Dia']) ?> >Jueves</option>
                            <option value="VIE" <?php comprobarOption('VIE', $materia['Dia']) ?> >Viernes</option>
                            <option value="SAB" <?php comprobarOption('SAB', $materia['Dia']) ?> >Sábado</option>
                            <option value="DOM" <?php comprobarOption('DOM', $materia['Dia']) ?> >Domingo</option>
                        </select>
                        <img src="../assets/img/arrow-select.svg" alt="">
                    </div>
                    <p>Hora</p>
                    <input type="time" name="hora" id="hora" value="<?= $materia['Hora'] ?>">
                    <p>Profesor</p>
                    <div class="form-select">
                        <select name="profesor" id="profesor">
                            <?php foreach ($profesores as $profesor) { ?>
                            <option value="<?= $profesor['DNI'] ?>" <?php comprobarOption($profesor['DNI'], $materia['ID_Profesor']) ?> ><?= $profesor['Nombre'] . ' ' . $profesor['Apellidos'] ?></option>
                            <?php } ?>
                        </select>
                        <img src="../assets/img/arrow-select.svg" alt="">
                    </div>
                    <input type="submit" value="Confirmar">
                </form>
                <div>
                    <h3>Alumnos</h3>
                    <?php 
                        $num_alumnos = count($alumnos);
                        if ($num_alumnos == 0) { ?>
                            <p>No hay alumnos</p>
                    <?php 
                        } else {
                            foreach ($alumnos as $alumno) { ?>
                                <p><?= $alumno['Nombre'] . ' ' . $alumno['Apellidos'] ?></p>
                    <?php
                            }
                        }
                    ?>
                    <a href="alumnos_materia.php?id=<?= $materia_id ?>">Gestionar alumnos</a>
                </div>
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
<script src="../assets/js/index.js"></script>
</html>