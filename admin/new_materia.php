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
</head>
<body>
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
        <br><br>
        <input type="submit" value="Crear">
    </form>
</body>
</html>