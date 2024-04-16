<?php
    session_start();

    //Verificar si el usuario esta autenticado
    if (!isset($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }

    echo "Bienvenido " . $_SESSION['username'];

?>