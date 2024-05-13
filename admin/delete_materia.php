<?php 
    require('../config/conexion.php');

    $db = new PDO($conn,$fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $materia_id = $_GET['id'];

    $query = $db->prepare('DELETE FROM materia WHERE ID = ?');
    $query->execute([$materia_id]);
    $db = null;
    header('Location: gestion_materias.php');
    exit();
?>