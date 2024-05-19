<?php
    require('../config/conexion.php');

    $db = new PDO($conn,$fields['user'], $fields['pass']);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_GET['id'];

    $query = $db->prepare(('DELETE FROM personal WHERE DNI = ?'));
    $query->execute([$user_id]);
    $db = null;
    header('Location: gestion_users.php');
    exit()
?>