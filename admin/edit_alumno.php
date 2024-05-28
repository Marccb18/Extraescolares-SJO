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
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];

    $query = $db->prepare('SELECT a.Nombre, a.Apellidos, a.ID_Materia, m.Nombre as NombreMateria FROM alumno a LEFT JOIN materia m ON a.ID_Materia = m.ID WHERE a.ID = :id');
    $query->bindParam(':id', $id);
    $query->execute();
    $alumno = $query->fetch(PDO::FETCH_ASSOC);

    $materias = $db->query('SELECT ID, Nombre FROM materia ORDER BY Nombre');
    $materias = $materias->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Editar Alumno</title>
</head>
<body>
<!DOCTYPE html>
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
                <a href="./admin_dashboard.php">
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
                    <h3>Editar Alumno</h3>
                    <p>Edita al alumno <?= $alumno['Nombre'] . ' ' . $alumno['Apellidos'] ?></p>
                </div>
            </div>
            <div id="main-content">
                <form action="update_alumno.php" method="post">
                    <input type="hidden" name="id" id="id" value="<?= $id ?>">
                    <p>Nombre</p>
                    <input type="text" name="nombre" id="nombre" value="<?= $alumno['Nombre'] ?>">
                    <p>Apellidos</p>
                    <input type="text" name="apellidos" id="apellidos" value="<?= $alumno['Apellidos'] ?>">
                    <p>Materia</p>
                    <div class="form-select">
                        <select name="materia">
                        <?php foreach($materias as $materia) { ?>
                            <option value="<?= $materia['ID'] ?>" <?php comprobarOption($materia['ID'], $alumno['ID_Materia']) ?> ><?= $materia['Nombre'] ?></option>
                        <?php } ?>
                        </select>
                        <img src="../assets/img/arrow-select.svg" alt="">
                    </div>
                    <input type="submit" value="Guardar">
                </form>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/index.js"></script>
</html>