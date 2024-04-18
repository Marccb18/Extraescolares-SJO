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

    function showMaterias($db) {
        $showMaterias = $db->query("SELECT * FROM materia where ID_Profesor = :id");
        $showMaterias->execute(array($_SESSION['id'] => ':id'));
        $materias = $showMaterias->fetchAll(PDO::FETCH_ASSOC);
        return $materias;
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor Dashboard</title>
    <link rel="stylesheet" href="../assets/css/profesor_dashboard.css">
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
            <li>
                <a href="#">
                    <img src="../assets/img/layout-grid.svg" alt="Layout icon">
                    Materias
                </a>
            </li>
        </ul>


        <form action="profesor_dashboard.php" method="post">
            <input type="submit" value="logout" name="logout">
        </form>
        
    </div>
    <div id="main">
        <div id="content">
            <div id="top-content">
                <ul>
                    <li class="active">
                        <a href="#">Clases</a>
                    </li>
                    <li >
                        <a href="#">Alumnos</a>
                    </li>
                </ul>
                <a href="#" id="pasar-lista">
                    <img src="../assets/img/plus-circled.svg" alt="Pasar Lista">
                    Pasar Lista
                </a>
            </div>
            <div id="title">
                <h3>Inicio</h3>
                <p>Busca entre todas tus clases</p>
            </div>
            <div id="filter">
                <div id="clases">
                    <p>Clases</p>
                    <select name="clases" id="select-clases">
                        <option value="">Todas</option>
                    </select>
                </div>
            </div>
                        <?php
                            $materias = showMaterias($db);
                            foreach ($materias as $materia => $i) {
                                echo "$materia == $i";
                            }
                        ?>
        </div>
    </div>
</body>
</html>