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
    $materias = $db->query("SELECT * FROM materia ORDER BY Nombre");
    $materias = $materias->fetchAll(PDO::FETCH_ASSOC);

    $id_materias = array_column($materias,'ID');

    $query = $db->prepare("SELECT * FROM personal WHERE ROL = 'PRO'");
    $query->execute();
    $profesores = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $db->prepare("SELECT * FROM alumno WHERE ID_Materia IN (" . implode(',', $id_materias) . ")");
    $query->execute();
    $alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

    $profesores_map = array();
    $profesores_mobile = array();
    foreach ($profesores as $profesor) {
        $profesores_map[$profesor['DNI']] = $profesor['Nombre'];
        $profesores_mobile[$profesor['DNI']] = $profesor['Nombre'] . ' ' . $profesor['Apellidos'];
    }
    
    $db = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Materias</title>
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
            <li >
                <a href="./gestion_users.php">
                    <img src="../assets/img/Vector.svg" alt="Students icon">
                    Usuarios
                </a>
            </li>
            <li class="active"> 
                <a href="#">
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
            <div id="topcontent">
                <div id="title" style="border: none; padding: 0;">
                    <h3>Materias</h3>
                    <p>Busca entre todas las materias<p>
                </div>
                <a href="new_materia.php" id="button-top">
                    <img src="../assets/img/plus-circled.svg" alt="Crear Materia">
                    Crear Materia
                </a>
            </div>
            <div class="main-content">
                <table id="table-desktop">
                    <tr>
                        <th>Nombre</th>
                        <th>Profesor</th>
                        <th>Alumnos</th>
                        <th class="th-buttons">Editar</th>
                        <th class="th-buttons">Eliminar</th>
                    </tr>
                    <?php foreach ($materias as $materia) {?>
                        <tr>
                            <td><?= $materia['Nombre'] ?></td>
                            <td>
                                <?= $profesores_map[$materia['ID_Profesor']] ?? '-' ?>
                            </td>
                            <td>
                                <?php 
                                    $count = 0;
                                    foreach ($alumnos as $alumno) {
                                        if ($alumno['ID_Materia'] == $materia['ID']) {
                                            $count++;
                                        }
                                    }
                                    echo $count;
                                ?>
                            </td>
                            <td>
                                <a style="background-color: #000;" class="button-table" href="edit_materia.php?id=<?= $materia['ID'] ?>">
                                    <img src="../assets/img/pen.svg"" alt="">
                                    Editar
                                </a>
                            </td>
                            <td style="padding-right: 0; width: 12%;">
                                <a class="button-table" href="delete_materia.php?id=<?= $materia['ID'] ?>">
                                    <img src="../assets/img/trash.svg" alt="">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <div id="table-mobile">
                    <?php foreach($materias as $materia) { ?>
                        <details>
                            <summary>
                                <img src="../assets/img/arrow-select.svg" alt="">
                                <p><?= $materia['Nombre'] ?></p>
                            </summary>
                            <div class="details-content"  style="padding-bottom: 10px;">
                                <p>
                                    Profesor: <?= $profesores_mobile[$materia['ID_Profesor']] ?? '-' ?><br>
                                    Alumnos: <?php
                                                $count = 0;
                                                foreach ($alumnos as $alumno) {
                                                    if ($alumno['ID_Materia'] == $materia['ID']) {
                                                        $count++;
                                                    }
                                                }
                                                echo $count;
                                            ?>
                                </p>
                                <div>
                                    <a style="background-color: #000;" class="button-table" href="edit_materia.php?id=<?= $materia['ID'] ?>">
                                        <img src="../assets/img/pen.svg"" alt="">
                                        Editar
                                    </a>
                                    <a class="button-table" href="delete_materia.php?id=<?= $materia['ID'] ?>">
                                        <img src="../assets/img/trash.svg" alt="">
                                        Eliminar
                                    </a>
                                </div>
                            </div>
                        </details>
                    <?php } ?>
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