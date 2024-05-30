<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'PRO') {
    header('Location: ../index.php');
    exit();
}
$currentDate = date('d-m-Y');

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

#historial de faltas desde el 1 de septiembre hasta la fecha actual teniendo en cuenta que solo hay una clase por semana
$prof = ['Nombre' => $data['profesor_nombre'], 'Apellidos' => $data['profesor_apellidos'], 'DNI' => $data['profesor_dni']];
$class = ['Nombre' => $data['materia_nombre'], 'ID' => $data['materia_id'], 'ID_profesor' => $data['profesor_dni'],];

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
            <h2>Clase de <?php switch ($data['Dia']) {
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
                <!-- la clases empiezan el 1 de septiembre hasta el 30 de junio -->
                <?php
                
                $date = new DateTime('2021-09-01');
                $today = new DateTime($currentDate);
                echo $date->format('d-m-Y');
                while ($date <= $today) {
                    $date->add(new DateInterval('P7D'));
                    echo $date->format('d-m-Y');
                }
                ?>

           </div>
        </div>

    </div>


</body>