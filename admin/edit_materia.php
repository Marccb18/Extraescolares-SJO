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

    $materia_id = $_GET['id'];

    $query = $db->prepare('SELECT * FROM materia WHERE ID = :id');
    $query->bindParam(':id', $materia_id);
    $query->execute();
    $materia = $query->fetch(PDO::FETCH_ASSOC);

    $profesores = $db->query("SELECT * FROM personal WHERE ROL = 'PRO' ");
    $profesores = $profesores->fetchAll(PDO::FETCH_ASSOC);

    $query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia = :id');
    $query->bindParam(':id', $materia_id);
    $query->execute();
    $alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="icon" href="../assets/img/logoSJO-fav.svg">
    <title>Editar Materia</title>
</head>
<body>
    <form action="update_materia.php" method="post">
        <input type="hidden" name="id" value=<?= $materia_id ?> >
        <p>Nombre</p>
        <input type="text" name="nombre" value="<?= $materia['Nombre'] ?>" id="nombre">
        <p>Dia</p>
        <select name="dia" id="dia">
            <option value="LUN" <?php comprobarOption('LUN', $materia['Dia']) ?> >Lunes</option>
            <option value="MAR" <?php comprobarOption('MAR', $materia['Dia']) ?> >Martes</option>
            <option value="MIE" <?php comprobarOption('MIE', $materia['Dia']) ?> >Miércoles</option>
            <option value="JUE" <?php comprobarOption('JUE', $materia['Dia']) ?> >Jueves</option>
            <option value="VIE" <?php comprobarOption('VIE', $materia['Dia']) ?> >Viernes</option>
            <option value="SAB" <?php comprobarOption('SAB', $materia['Dia']) ?> >Sábado</option>
            <option value="DOM" <?php comprobarOption('DOM', $materia['Dia']) ?> >Domingo</option>
        </select>
        <p>Hora</p>
        <input type="time" name="hora" id="hora" value="<?= $materia['Hora'] ?>">
        <p>Profesor</p>
        <select name="profesor" id="profesor">
            <?php foreach ($profesores as $profesor) { ?>
                <option value="<?= $profesor['DNI'] ?>" <?php comprobarOption($profesor['DNI'], $materia['ID_Profesor']) ?> ><?= $profesor['Nombre'] . ' ' . $profesor['Apellidos'] ?></option>
            <?php } ?>
        </select>
        <br><br>
        <input type="submit" value="Confirmar">
    </form>

    <h3>Alumnos</h3>
    <?php 
        $num_alumnos = count($alumnos);
        if ($num_alumnos == 0) { ?>
            <p>No hay alumnos</p>
    <?php 
        } else {
            foreach ($alumnos as $alumno) { ?>
                <p><?= $alumno['Nombre'] . ' ' . $alumno['Apellidos'] ?></p>
    <?php
            }
        }
    ?>
    <a href="alumnos_materia.php?id=<?= $materia_id ?>">Gestionar alumnos</a>
</body>
<script src="../assets/js/index.js"></script>
</html>