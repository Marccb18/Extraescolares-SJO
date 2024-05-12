<?php 
    require('../config/conexion.php');

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $dia = $_POST['dia'];
        $hora = $_POST['hora'];
        $profesor = $_POST['profesor'];

        try {
            $query = $db->prepare("UPDATE materia SET Nombre = :nombre, Dia = :dia, Hora = :hora, ID_Profesor = :profesor WHERE ID = :id");
            $query->execute(array(":nombre" => $nombre, ":dia" => $dia, ":hora" => $hora, ":profesor" => $profesor, ":id" => $id));
            $db = null;
            header('Location: gestion_materias.php');
            exit();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $db = null;
        header('Location: gestion_materias.php');
        exit();
    }
?>
