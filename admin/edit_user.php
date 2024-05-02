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

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_GET['id'];

    $query = $db->prepare('SELECT * FROM personal WHERE DNI = ?');
    $query->execute([$user_id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    $db = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <form action="update_user.php" method="post">
        <input type="hidden" name="dni" value="<?= $user['DNI'] ?>">
        <p>Nombre</p>
        <input type="text" name="nombre" value="<?= $user['Nombre'] ?>">
        <p>Apellidos</p>
        <input type="text" name="apellidos" value="<?= $user['Apellidos'] ?>" >
        <p>Email</p>
        <input type="email" name="email" value="<?= $user['Email'] ?>">
        <p>Contraseña</p>
        <input type="text" name="password" value="<?= $user['Password'] ?>">
        <p>Teléfono</p>
        <input type="number" name="telefono" id="telefono" value="<?= $user['Telefono'] ?>">
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