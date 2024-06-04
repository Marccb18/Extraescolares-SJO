<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'PRO') {
    header('Location: ../index.php');
    exit();
}
$currentDate = date('Y-m-d');


$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$class_id = $_GET['id'];

$query = $db->prepare('SELECT * FROM materia WHERE ID = ?');
$query->execute([$class_id]);
$class = $query->fetch(PDO::FETCH_ASSOC);

$query = $db->prepare('SELECT * FROM personal WHERE DNI = :id_profesor');
$query->bindParam(':id_profesor', $class['ID_Profesor']);
$query->execute();
$prof = $query->fetch(PDO::FETCH_ASSOC);

$query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia = :id_materia');
$query->bindParam(':id_materia', $class['ID']);
$query->execute();
$alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

$showFaltas = $db->prepare("SELECT * FROM faltas WHERE (ID_Materia = :id_materia AND Fecha = :Fecha)");
$showFaltas->bindParam(':id_materia', $class['ID']);
$showFaltas->bindParam(':Fecha', $currentDate);
$showFaltas->execute();
$Faltas = $showFaltas->fetchAll(PDO::FETCH_ASSOC);



$db = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coord Dashboard</title>
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
                <a href="coord_dashboard.php">
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


        <form action="coord_dashboard.php" method="post">
            <input type="submit" value="logout" name="logout">
        </form>

    </div>
    <div id="main">
        <div id="content">
            <div id="title">
                <php>
                    <h3><?= $class['Nombre'] ?></h3>
                    <p><?= $prof['Nombre'] ?></p>
                    <p><?= $prof['Apellidos'] ?></p>

                </php>
            </div>
            <div class="main-content">
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Falta</th>
                    </tr>
                    <?php foreach ($alumnos as $alumno) {
                        $check = '';
                        foreach ($Faltas as $falta) {
                            if ($alumno['ID'] == $falta['ID_Alumno'] and $falta['Fecha'] = $currentDate) {
                                $check = 'Checked    ';
                            }
                        } ?>
                        <form method="post">
                            <tr>
                                <td>
                                    <img src="../assets/img/user.svg" alt="user">
                                    <?= $alumno['Nombre'] ?>
                                </td>
                                <td><?= $alumno['Apellidos'] ?></td>
                                <td>
                                    <input type="checkbox" name="selected_alumnos[]" value="<?= $alumno['ID'] ?>" <?= $check ?>> Falta<br>
                                </td>
                            </tr>
                        <?php } ?>
                </table>
                <input type="submit" name="submit_button" value="Submit">
                </form>
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
        <form action="admin_dashboard.php" method="post">
            <button type="submit" name="logout">
                <img src="../assets/img/logout.svg" alt="logout-icon">
            </button>
        </form>
    </div>

</html>
<?php
// $currentDate = '2020-04-6';
if (isset($_POST['submit_button'])) {
    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!empty($_POST['selected_alumnos'])) {
        $selectedStudents = $_POST['selected_alumnos'];

        foreach ($selectedStudents as $stud) {
            $query = $db->prepare('INSERT INTO faltas (ID_Alumno, ID_Materia, Fecha) VALUES (:id_alumno, :id_materia,:fecha )');
            $query->bindParam(':id_alumno', $stud);
            $query->bindParam(':id_materia', $class_id);
            $query->bindParam(':fecha', $currentDate);
            $query->execute();
        }
    } else {
        foreach ($alumnos as $alumno) {
            foreach ($Faltas as $falta) {
                if ($alumno['ID'] == $falta['ID_Alumno']) {
                    $query = $db->prepare('DELETE FROM faltas WHERE ID_Alumno = :id_alumno AND Fecha = :fecha');
                    $query->bindParam(':id_alumno', $alumno['ID']);
                    $query->bindParam(':fecha', $currentDate);
                    $query->execute();
                }
            }
        }
    }
    header("coord_dashboard.php");
    exit();
}
$db = null;
?>