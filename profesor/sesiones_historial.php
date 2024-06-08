<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'PRO') {
    header('Location: ../index.php');
    exit();
}
$currentDate = date('d-m-Y');
$currentMonth = date('m');
if ($currentMonth >=9 && $currentMonth <=12) {
    $currentYear = date('Y');
} else {
    $currentYear = date('Y') - 1;
}
$fechaInicio = date('d-m-Y', strtotime('01-09-' . $currentYear));

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

#historial de faltas desde el 1 de septiembre hasta la fecha actual teniendo en cuenta que solo hay una clase por semana
$prof = ['Nombre' => $data['profesor_nombre'], 'Apellidos' => $data['profesor_apellidos'], 'DNI' => $data['profesor_dni']];
$class = ['Nombre' => $data['materia_nombre'], 'ID' => $data['materia_id'], 'ID_profesor' => $data['profesor_dni'],];
$dia_de_materia = $data['Dia'];
$conversor = ['LUN' => 'monday', 'MAR' => 'tuesday', 'MIE' => 'wednesday', 'JUE' => 'thursday', 'VIE' => 'friday', 'SAB' => 'saturday', 'DOM' => 'sunday'];
$dia_de_materia = $conversor[$dia_de_materia];
$ultimaClase_dada = date('d-m-Y', strtotime('last ' . $dia_de_materia));
$query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia = :id_materia');
$query->bindParam(':id_materia', $class['ID']);
$query->execute();
$alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de faltas</title>
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
            <li >
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
                <a href="profesor_sesiones.php" class="active">
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
                                <img src="../assets/img/person.svg" alt="" style="margin-right: 6px; font-size: 0.85rem">
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
            <h1>Historial de faltas</h1>
            <h2><?= $data['materia_nombre'] ?>
             <?php switch ($data['Dia']) {
                            case 'LUN':
                                echo 'Lunes';
                                break;
                            case 'MAR':
                                echo 'Martes';
                                break;
                            case 'MIE':
                                echo 'Miércoles';
                                break;
                            case 'JUE':
                                echo 'Jueves';
                                break;
                            case 'VIE':
                                echo 'Viernes';
                                break;
                            case 'SAB':
                                echo 'Sábado';
                                break;
                            case 'DOM';
                                echo 'Domingo';
                                break;
                        } ?> a las <?php echo $data['Hora'] ?></h2>
           <div class="historic-cards">
                <p><?= $currentYear ?>-<?= $currentYear + 1 ?></p>
                <div class="select-container">
                    <input type="date" id="date" name="date" value="<?=date('Y-m-d', strtotime($currentDate)); ?>" min="<?= date('Y-m-d',strtotime($fechaInicio ))?>" max="<?= date('Y-m-d',strtotime($currentDate)) ?>">

                </div>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                

                <?php       
                     /* quiero coger el dia en nombre en el que estamos actualmente con date pasar a minuscula */
                     $diaAcrtual = date('l');
                        if (strtolower($diaAcrtual) == $dia_de_materia) {
                            echo '<div class="historic-card">';
                            echo '<p>'. $currentDate  .'</p>';
                            echo '<a href="pasar_lista.php?id=' . $class['ID'] . '&fecha=' . date('Y-m-d', strtotime($currentDate)) . '" id="button-top">Ver faltas</a>';
                            echo '</div>';
                        }
                        while (strtotime($ultimaClase_dada) >= strtotime($fechaInicio)) {
                            echo '<div class="historic-card">';
                            echo '<p>' . $ultimaClase_dada . '</p>';
                            echo '<a href="pasar_lista.php?id=' . $class['ID'] . '&fecha=' . date('Y-m-d', strtotime($ultimaClase_dada)) . '" id="button-top">Ver faltas</a>';
                            echo '</div>';
            
                            $ultimaClase_dada = date('d-m-Y', strtotime($ultimaClase_dada . ' - 7 days'));
                        }
                ?>
                </div>
           </div>
        </div>
    </div>
    <div id="mobile-menu">
        <a href="./profesor_dashboard.php" >
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./profesor_dashboard_alumnos.php">
            <img src="../assets/img/Vector.svg" alt="gestion-users-icon">
        </a>
        <a href="./profesor_sesiones.php" class="active">
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


</body>