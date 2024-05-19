<?php
    require('../config/conexion.php');

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];

    $query = $db->prepare("DELETE FROM alumno WHERE ID = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $db = null;
    header('Location: gestion_alumnos.php');
?>