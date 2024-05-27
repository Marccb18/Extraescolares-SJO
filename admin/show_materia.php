<?php
    session_start();
    require('../config/conexion.php');

    if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM') {
        header('Location: ../index.php');
        exit();
    }


    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $class_id = $_GET['id'];
    
    $query = $db->prepare('SELECT * FROM materia WHERE ID = ?');
    $query->execute([$class_id]);
    $class = $query->fetch(PDO::FETCH_ASSOC);
    
    $query = $db->prepare('SELECT * FROM personal WHERE DNI = :id_profesor');
    $query->bindParam(':id_profesor', $class['ID_Profesor']);
    $query->execute();
    $prof = $query->fetch(PDO::FETCH_ASSOC);

    $query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia = :id_materia ORDER BY Apellidos');
    $query->bindParam(':id_materia', $class['ID']);
    $query->execute();
    $alumnos = $query->fetchAll(PDO::FETCH_ASSOC);


    $db = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Materia</title>
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
                    <h3><?= $class['Nombre'] ?></h3>
                    <p>Mira todos los alumnos de esta clase<p>
                </div>
            </div>
            <div class="main-content">
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                    </tr>
                    <?php foreach ($alumnos as $alumno) { ?>
                        <tr>
                            <td><?= $alumno['Nombre'] ?></td>
                            <td><?= $alumno['Apellidos'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/index.js"></script>
</html>