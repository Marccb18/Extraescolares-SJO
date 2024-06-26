<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'COO') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['fecha'])) {
    $currentDate = $_GET['fecha'];
} else {
    $currentDate = date('Y-m-d');
}


$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$class_id = $_GET['id'];

$query = $db->prepare("
SELECT m.ID AS materia_id, m.Nombre AS materia_nombre, m.Dia, m.Hora,
p.DNI AS profesor_dni, p.Nombre AS profesor_nombre, p.Apellidos AS profesor_apellidos
FROM materia m
INNER JOIN personal p ON m.ID_Profesor = p.DNI
WHERE m.ID = :id_materia
GROUP BY m.ID, m.Nombre, m.Dia, m.Hora, p.DNI, p.Nombre, p.Apellidos;
");
$query->bindParam(':id_materia', $class_id);
$query->execute();

$data = $query->fetch(PDO::FETCH_ASSOC);


$prof = ['Nombre' => $data['profesor_nombre'], 'Apellidos' => $data['profesor_apellidos']];
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
            $query = $db->prepare('INSERT INTO faltas (ID_Alumno, ID_Materia, Fecha) VALUES (:id_alumno, :id_materia, :fecha )');
            $query->bindParam(':id_alumno', $stud);
            $query->bindParam(':id_materia', $class_id);
            $query->bindParam(':fecha', $currentDate);
            $query->execute();
        }
    }
    header("Location: coord_dashboard.php");
    $db = null;
    exit();
}

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
    <link rel="stylesheet" href="../assets/css/pasar-lista.css">
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
                    Alumnos
                </a>
            </li>
            <li>
                <a href="./coordinador_sesiones.php">
                    <img src="../assets/img/library.svg" alt="Library icon">
                    Sesiones
                </a>
            </li>
            <li>
                <a href="./gestion_materias.php" class="active">
                    <img src="../assets/img/layout-grid.svg" alt="Subjects icon">
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
                        <form action="perfil.php" method="post">
                            <button type="submit" name="perfil">
                                <div style="display: flex;  align-items: center;">
                                    <img src="../assets/img/person.svg" alt="" style="margin-right: 6px;">
                                    Ver Perfil
                                </div>
                                <img src="../assets/img/chevron-right.svg" alt="">
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="coord_dashboard.php" method="post" id="logout-form">
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
            <div id="title" style="padding-top: 0;">
                <php>
                    <h3><?= $class['Nombre'] ?></h3>
                    <p><?= $prof['Nombre'] ?></p>
                    <p><?= $prof['Apellidos'] ?></p>
                </php>
            </div>
            <div id="main-content" style="margin-top: 0;">
                <form action="pasar_lista.php?id=<?= $class_id  ?>&fecha=<?= $currentDate ?>" method="post" id="form-pasarlista">
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
                                    $check = 'Checked';
                                }
                            } ?>
                            <tr>
                                <td>
                                    <img src="../assets/img/user.svg" alt="user">
                                    <?= $alumno['Nombre'] ?>
                                </td>
                                <td><?= $alumno['Apellidos'] ?></td>
                                <td style="padding-right: 0;text-overflow: unset; padding-left: 2%">
                                    <input type="checkbox" name="selected_alumnos[]" value="<?= $alumno['ID'] ?>" <?= $check ?>>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <input type="submit" name="submit_button" value="Submit" id="submit-button">
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
        <a href="./coordinador_sesiones.php">
            <img src="../assets/img/layout-grid.svg" alt="gestion-materias-icon">
        </a>
        <a href="./perfil.php">
            <img src="../assets/img/person.svg" alt="person-icon">
        </a>
        <form action="coord_dashboard.php" method="post">
            <button type="submit" name="logout">
                <img src="../assets/img/logout.svg" alt="logout-icon">
            </button>
        </form>
    </div>
    <script src="../assets/js/index.js"></script>
</body>

</html>