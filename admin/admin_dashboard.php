<?php
    session_start();

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

<form action="../index.php" method="post">
    <input type="submit" name="logout" value="Cerrar Sesión">
</form>