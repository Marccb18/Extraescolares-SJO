<?php
require('../config/conexion.php');

// Asignar valores a $conn y $fields['user'], $fields['pass'] antes de esta línea

try {
    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $dia = $_POST['dia'];
        $hora = $_POST['hora'];
        $profesor = $_POST['profesor'];

        // Corrección en la consulta SQL
        $query = $db->prepare("INSERT INTO materia (Nombre, Dia, Hora, ID_Profesor) VALUES (:nombre, :dia, :hora, :profesor)");

        // Ajustar los nombres de los parámetros y bindearlos
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':dia', $dia);
        $query->bindParam(':hora', $hora);
        $query->bindParam(':profesor', $profesor);

        $query->execute();

        $db = null;
        header('Location: gestion_materias.php');
        exit();
    }
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error: " . $e->getMessage();
    die();
}
?>
