<?php
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM') {
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
    <link rel="icon" href="../assets/img/logoSJO-fav.svg">
    <title>Crear Usuario</title>
</head>
<body>
    <form action="insert_user.php" method="post">
        <p>DNI</p>
        <input type="text" name="dni" value="" maxlength="10">
        <p>Nombre</p>
        <input type="text" name="nombre" value="">
        <p>Apellidos</p>
        <input type="text" name="apellidos" value="" >
        <p>Email</p>
        <input type="email" name="email" value="">
        <p>Contraseña</p>
        <input type="text" name="password" value="">
        <p>Teléfono</p>
        <input type="number" name="telefono" id="telefono" value="" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9">
        <p>Rol</p>
        <select name="rol" id="rol_id">
            <option value="PRO">Profesor</option>
            <option value="COO">Coordinador</option>
            <option value="ADM">Administrador</option>
        </select>
        <input type="submit" value="Confirmar">
    </form>
</body>
</html>