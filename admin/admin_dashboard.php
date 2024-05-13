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
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $showMaterias = $db->query("SELECT * FROM materia");
    $materias = $showMaterias->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
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
                <a href="#">
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
                <a href="#">
                    <img src="../assets/img/library.svg" alt="Library icon">
                    Sesiones
                </a>
            </li>
            <li>
                <a href="./gestion_materias.php">
                    <img src="../assets/img/layout-grid.svg" alt="Layout icon">
                    Materias
                </a>
            </li>
        </ul>

        <form action="admin_dashboard.php" method="post">
            <input type="submit" value="logout" name="logout">
        </form>
        
    </div>
    <div id="main">
        <div id="content">
            <div id="topcontent">
                <div id="title">
                    <h3>Inicio</h3>
                    <p>Busca entre todas las clases</p>
                </div>
            </div>
            <div id="filter">
                <div id="clases">
                    <p>Clases</p>
                    <div id="select-container">
                        <select name="clases">
                            <option value="">Todas</option>
                            <?php
                                foreach ($materias as $materia) { ?>
                                    <option value="<?= $materia['Nombre']?>"><?= $materia['Nombre'] ?></option>
                            <?php } ?>
                        </select>
                        <img src="../assets/img/arrow-select.svg" alt="Arrow Select">
                    </div>
                </div>
                <div id="fecha">
                    <p>Fecha</p>
                    <div id="date-container">
                        <img src="../assets/img/Calendar.svg" alt="Calendar">
                        <input type="date">
                    </div>
                </div>
            </div>
            <div id="main-content">
                <a href="prueba.php">prueba</a>
                <?php 
                    foreach ($materias as $materia) { ?>
                        <a class="item" href="show_materia.php?id=<?= $materia['ID'] ?>">
                            <img src="../assets/img/logoSJO.svg" alt="logo">
                            <p class="itemtitle"><?= $materia['Nombre'] ?></p>
                            <p class="itemsub"><?php
                                switch ($materia['Dia']) {
                                    case 'LUN':
                                        echo 'Lunes ';
                                        break;
                                    case 'MAR':
                                        echo 'Martes ';
                                        break;
                                    case 'MIE':
                                        echo 'Miércoles ';
                                        break;
                                    case 'JUE':
                                        echo 'Jueves ';
                                        break;
                                    case 'VIE':
                                        echo 'Viernes ';
                                        break;
                                    case 'SAB':
                                        echo 'Sábado ';
                                        break;
                                    case 'DOM';
                                        echo 'Domingo ';
                                        break;
                                }?>
                                · 
                                <?= date('H:i',strtotime($materia['Hora'])) ?>
                            </p>
                        </a>
                <?php }?>
            </div>
        </div>
    </div>
</body>
</html>