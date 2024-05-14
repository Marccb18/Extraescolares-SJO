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

$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$showMaterias = $db->query("SELECT * FROM materia where ID_Profesor = '$_SESSION[id]'");
$materias = $showMaterias->fetchAll(PDO::FETCH_ASSOC);
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


        <form action="profesor_dashboard.php" method="post">
            <input type="submit" value="logout" name="logout">
        </form>
        <div>
            <div class="user-info-container">
                <div class="user-info">
                    <img src="../assets/img/logoSJO.svg" alt="Logo Sant Josep">
                    <p><?php echo $_SESSION['username'] ?></p>
                </div>
                <img src="../assets/img/two-arrows.png" alt="Vector img" class="vector-img">
            </div>
            <div style="margin-top: 8px; height: 80px; border: 1px solid #E0E0E0; 
            border-radius: 8px; padding: 8px; width: 226px; box-sizing: border-box; margin-left: 16px;">
                <ul style="list-style-type: none;
                padding: 0; margin: 0; display: flex; flex-direction: column; justify-content: space-around; height: 100%;">
                    <li style="font-size: 14px; align-items: center;">
                        <a href="" style="display: flex;  align-items: center; justify-content: space-between;">
                            <div style="display: flex;  align-items: center;">
                                <img src="../assets/img/person.svg" alt="" style="width: 16px;">
                                Ver Perfil
                            </div>
                            <img src="../assets/img/chevron-right.svg" alt="" style="width: 16px;">
                        </a>
                    </li>
                    <li style="font-size: 14px;">
                        <a href="../config/logout.php" style="display: flex;  align-items: center;
                         justify-content: space-between; align-items: center;">
                            <div style="display: flex;  align-items: center;">
                                <img src="../assets/img/logout.svg" alt="" style="width: 16px;">
                                Cerrar Sesion
                            </div>
                            <img src="../assets/img/chevron-right.svg" alt="" style="width: 16px;">
                        </a>
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
            <div id="main-content">
                <?php
                $count = 0;
                foreach ($materias as $materia) {
                    // if ($materia['Dia'] == getDayOfWeek()
                    if ($materia['Dia'] == 'LUN'
                    ) { $count++;?>

                        <a class="item" href="pasar_lista.php?id=<?= $materia['ID'] ?>">
                            <img src="../assets/img/logoSJO.svg" alt="logo">
                            <p class="itemtitle"><?= $materia['Nombre'] ?></p>
                            <p class="itemsub">
                                <?= $materia['Dia'] ?>
                                <?= date('H:i', strtotime($materia['Hora'])) ?>
                            </p>

                        </a>
                        
                <?php }
                } if($count==0){ echo '<h2>no hay materias hoy</h2>';} $matid=$materias[0]['ID'];
                if ($count==1){  header("Location: pasar_lista.php?id=$matid ");}?>
            </div>
        </div>
    </div>
</body>

</html>