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

    function getDayOfWeek() {
        $dayOfWeek = date('w');
        $spanishDays = array("dom", "lun", "mar", "mie", "jue", "vie", "sab");
        if ($dayOfWeek >= 0 && $dayOfWeek <= 6) {
            return strtoupper($spanishDays[$dayOfWeek]);
        }
    }

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $db->prepare('SELECT * FROM materia WHERE Dia = :dia ORDER BY Hora ASC');
    $query->bindParam(':dia', getDayOfWeek());
    $query->execute();
    $materias = $query->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Sesiones</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
    <link rel="icon" href="../assets/img/logoSJO-fav.svg">
</head>
<body>
    
</body>
</html>