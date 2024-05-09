<?php
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM' ) {
        header('Location: ../index.php');
        exit();
    }
    if (isset($_POST['logout'])) {
        require_once('../config/logout.php');
        logout();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Materia</title>
</head>
<body>
    <form action="insert_materia.php">
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
    </form>
</body>
</html>