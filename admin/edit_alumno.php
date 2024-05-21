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

    $query = $db->prepare('SELECT a.Nombre, a.Apellidos, a.ID_Materia, m.Nombre as NombreMateria FROM alumno a LEFT JOIN materia m ON a.ID_Materia = m.ID WHERE a.ID = :id ');
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
    <form action="update_alumno.php" method="post">
        <input type="hidden" name="id" id="id" value="<?= $id ?>">
        <p>Nombre</p>
        <input type="text" name="nombre" id="nombre" value="<?= $alumno['Nombre'] ?>">
        <p>Apellidos</p>
        <input type="text" name="apellidos" id="apellidos" value="<?= $alumno['Apellidos'] ?>">
        <select name="materia" id="select">
            <?php foreach($materias as $materia) { ?>
                <option value="<?= $materia['ID'] ?>" <?php comprobarOption($materia['ID'], $alumno['ID_Materia']) ?> ><?= $materia['Nombre'] ?></option>
            <?php } ?>
        </select>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>