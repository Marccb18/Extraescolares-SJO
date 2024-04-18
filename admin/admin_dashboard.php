<?php
    session_start();

    //Verificar si el usuario esta autenticado
    if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM') {
        header('Location: ../index.php');
        exit();
    }
    if(isset($_POST['logout'])) {
        require_once('../config/logout.php');
        logout();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../assets/img/logoSJO.png">
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
    <h1>Hola <?= $_SESSION['username'] ?></h1>
    <form action="admin_dashboard.php" method="post">
        <input type="submit" name="logout" value="Cerrar Sesión">
    </form>
</body>
</html>