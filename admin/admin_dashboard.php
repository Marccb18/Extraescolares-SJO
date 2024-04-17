<?php
    session_start();

    //Verificar si el usuario esta autenticado
    if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
        exit();
    }

    echo "Bienvenido " . $_SESSION['username'];


    if(isset($_POST['submit'])) {
        require_once('../config/logout.php');
        logout();
    }
?>

<form action="admin_dashboard.php" method="post">
    <input type="submit" name="submit" value="Cerrar Sesión">
</form>