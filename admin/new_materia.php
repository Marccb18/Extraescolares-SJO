<?php
    session_start();
    require('../config/conexion.php');

    if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM' ) {
        header('Location: ../index.php');
        exit();
    }
    if (isset($_POST['logout'])) {
        require_once('../config/logout.php');
        logout();
    }

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $profesores = $db->query("SELECT * FROM personal WHERE ROL = 'PRO'");
    $profesores = $profesores->fetchAll(PDO::FETCH_ASSOC);

    $db = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Materia</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
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
            <div id="main-content">
                <form action="insert_materia.php" method="post">
                    <p>Nombre</p>
                    <input type="text" name="nombre" value="" id="">
                    <p>Dia</p>
                    <select name="dia" id="dia">
                        <option value="LUN">Lunes</option>
                        <option value="MAR">Martes</option>
                        <option value="MIE">Miércoles</option>
                        <option value="JUE">Jueves</option>
                        <option value="VIE">Viernes</option>
                        <option value="SAB">Sábado</option>
                        <option value="DOM">Domingo</option>
                    </select>
                    <p>Hora</p>
                    <input type="time" name="hora" id="hora">
                    <p>Profesor</p>
                    <select name="profesor" id="profesor">
                        <?php foreach ($profesores as $profesor) { ?>
                            <option value="<?= $profesor['DNI'] ?>"><?= $profesor['Nombre'] . ' ' . $profesor['Apellidos'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="Crear">
                </form>
            </div>
        </div>  
    </div>
</body>
<script src="../assets/js/index.js"></script>
</html>