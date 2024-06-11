<?php
session_start();
require('../config/conexion.php');

if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM') {
    header('Location: ../index.php');
    exit();
}

$db = new PDO($conn, $fields['user'], $fields['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$csv = $_FILES['file']['tmp_name'];
$csv = fopen($csv, 'r');

while (($line = fgetcsv($csv)) !== FALSE) {
    $db->query("INSERT INTO alumno (Nombre,Apellidos,ID_Materia) VALUES ('$line[0]','$line[1]','$line[2]')");
}

fclose($csv);
$db = null;
header('Location: ./gestion_alumnos.php');

