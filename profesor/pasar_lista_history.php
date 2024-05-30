<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'PRO') {
    header('Location: ../index.php');
    exit();
}
$currentDate = $_GET['date'] ;


$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$class_id = $_GET['id'];

$query = $db->prepare("
  SELECT m.ID AS materia_id, m.Nombre AS materia_nombre, m.Dia, m.Hora,
         p.DNI AS profesor_dni, p.Nombre AS profesor_nombre, p.Apellidos AS profesor_apellidos
  FROM materia m
  INNER JOIN personal p ON m.ID_Profesor = p.DNI
  INNER JOIN matriculas mt ON m.ID = mt.ID_Materia
  WHERE m.ID = :id_materia;
");
$query->bindParam(':id_materia', $class_id);
$query->execute();

$data = $query->fetch(PDO::FETCH_ASSOC);


$prof = ['Nombre' => $data['profesor_nombre'], 'Apellidos' => $data['profesor_apellidos'], 'DNI' => $data['profesor_dni']];
$class = ['Nombre' => $data['materia_nombre'], 'ID' => $data['materia_id'], 'ID_profesor' => $data['profesor_dni'],];


$query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia = :id_materia');
$query->bindParam(':id_materia', $class['ID']);
$query->execute();
$alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

$showFaltas = $db->prepare("SELECT * FROM faltas WHERE (ID_Materia = :id_materia AND Fecha = :Fecha)");
$showFaltas->bindParam(':id_materia', $class['ID']);
$showFaltas->bindParam(':Fecha', $currentDate);
$showFaltas->execute();
$Faltas = $showFaltas->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit_button'])) {
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
    if (!empty($_POST['selected_alumnos'])) {
        $selectedStudents = $_POST['selected_alumnos'];

        foreach ($selectedStudents as $stud) {
            $query = $db->prepare('INSERT INTO faltas (ID_Alumno, ID_Materia, Fecha) VALUES (:id_alumno, :id_materia,:fecha )');
            $query->bindParam(':id_alumno', $stud);
            $query->bindParam(':id_materia', $class_id);
            $query->bindParam(':fecha', $currentDate);
            $query->execute();
        }
    }
    header("Location: profesor_dashboard.php");
    $db = null;
    exit();
}

$db = null;

if ($_SESSION['id'] != $prof['DNI']) {
    header('Location: profesor_dashboard.php');
    exit();
}
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


        <form action="prof_dashboard.php" method="post">
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
            <div id="main-content">
                <table border="1">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Falta</th>
                    </tr>
                    <?php foreach ($alumnos as $alumno) {
                        $check = '';
                        foreach ($Faltas as $falta) {
                            if ($alumno['ID'] == $falta['ID_Alumno'] and $falta['Fecha'] = $currentDate) {
                                $check = 'Checked';
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
</body>

</html>