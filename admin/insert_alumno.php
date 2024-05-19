<?php
    require('../config/conexion.php');

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $materia = $_POST['materia'];

        try {
            $query = $db->prepare('INSERT INTO alumno (Nombre, Apellidos, ID_Materia) VALUES (:nombre, :apellidos, :id_materia);');
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':apellidos', $apellidos);
            $query->bindParam(':id_materia', $materia);
            $query->execute();

            $db = null;
            header('Location: gestion_alumnos.php');
            exit();
        } catch (PDOException $e) {
            echo "Error al insertar el registro: " . $e->getMessage();
        }
    }
?>