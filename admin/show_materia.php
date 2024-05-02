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

    $query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia = :id_materia');
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
    <title>Document</title>
    <p>Nombre: <?= $class['Nombre'] ?></p>
    <p>Profesor: <?= $prof['Nombre'] ?></p>
    <p>Alumnos:</p>
    <?php foreach ($alumnos as $alumno) { ?>
        <p> - <?= $alumno['Nombre'] . ' ' . $alumno['Apellidos'] ?></p>
    <?php } ?>
</head>
<body>
    
</body>
</html>