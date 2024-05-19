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
    $materias = $db->query("SELECT ID, Nombre FROM materia");
    $materias = $materias->fetchAll(PDO::FETCH_ASSOC);

    $db = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Alumno</title>
</head>
<body>
    <form action="insert_alumno.php" method="post">
        <p>Nombre</p>
        <input type="text" name="nombre" id="nombre">
        <p>Apellidos</p>
        <input type="text" name="apellidos" id="apellidos">
        <select name="materia" id="select">
            <?php foreach($materias as $materia) { ?>
                <option value="<?= $materia['ID'] ?>"><?= $materia['Nombre'] ?></option>
            <?php } ?>
        </select>
        <input type="submit" value="Crear">
    </form>
</body>
</html>