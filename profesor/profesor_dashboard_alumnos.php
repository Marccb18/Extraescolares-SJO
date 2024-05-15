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
    exit();
}

$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$showMaterias = $db->prepare("SELECT * FROM materia WHERE ID_Profesor = :profesor_id");
$showMaterias->execute(array(':profesor_id' => $_SESSION['id']));
$materias = $showMaterias->fetchAll(PDO::FETCH_ASSOC);

$id_materias = array_column($materias, 'ID');

$query =  $db->prepare("SELECT * FROM alumno WHERE ID_Materia IN (" . implode(',', $id_materias) . ")");
$query->execute();
$alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

$showFaltas = $db->prepare("SELECT * FROM faltas WHERE ID_Materia IN (" . implode(',', $id_materias) . ")");
$showFaltas->execute();
$Faltas = $showFaltas->fetchAll(PDO::FETCH_ASSOC);

$materiasMap = array();
foreach ($materias as $materia) {
    $materiasMap[$materia['ID']] = $materia['Nombre'];
}

$db = null;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor Dashboard</title>
    <link rel="stylesheet" href="../assets/css/profesor_dashboard.css">
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
                <img src="../assets/img/two-arrows.png" alt="Vector img" class="vector-img">
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
                        <form action="profesor_dashboard_alumnos.php" method="post">
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
                    <li>
                        <a href="profesor_dashboard.php">Clases</a>
                    </li>
                    <li class="active">
                        <a href="profesor/profesor_dashboard_alumnos.php">Alumnos</a>
                    </li>
                </ul>
                <a href="select_pasar_lista.php" id="pasar-lista">
                    <img src="../assets/img/plus-circled.svg" alt="Pasar Lista">
                    Pasar Lista
                </a>
            </div>
            <div id="title">
                <h3>Inicio</h3>
                <p>Busca entre todes tus alumnes</p>
            </div>
            <div id="main-content">
                <table border="1">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Materia</th>
                        <th>Faltas</th>
                    </tr>
                    <?php foreach ($alumnos as $alumno) { ?>
                        <tr>
                            <td>
                                <img src="../assets/img/user.svg" alt="user">
                                <?= $alumno['Nombre'] ?>
                            </td>
                            <td><?= $alumno['Apellidos'] ?></td>
                            <td>
                                <?= $materiasMap[$alumno['ID_Materia']] ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($Faltas as $Falta) {
                                    if ($Falta['ID_Alumno'] == $alumno['ID']) {
                                        $count++;
                                    }
                                }
                                echo $count;
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/index.js"></script>

</html>