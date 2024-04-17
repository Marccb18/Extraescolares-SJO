<?php
    require('../config/users_control.php');

    //Verificar si el usuario esta autenticado
    if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
        exit();
    }

    echo "Bienvenido " . $_SESSION['username'];


    if(isset($_POST['submit'])) {
        logout();
    }
?>

<form action="logout.php" method="post">
    <input type="submit" name="logout" value="Cerrar Sesión">
</form>