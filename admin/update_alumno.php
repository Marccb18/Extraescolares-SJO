<?php
    require('../config/conexion.php');
    
    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $materia = $_POST['materia'];
        try {
            $query = $db->prepare("UPDATE alumno SET Nombre = :nombre, Apellidos = :apellidos, ID_Materia = :id_materia WHERE ID = :id");
            $query->execute(array(":nombre" => $nombre, "apellidos" => $apellidos, ":id_materia" => $materia, ":id" => $id));
            $db = null;
            header('Location: gestion_alumnos.php');
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $db = null;
        header('Location: gestion_alumnos.php');
        exit();
    }

    $db = null;
?>