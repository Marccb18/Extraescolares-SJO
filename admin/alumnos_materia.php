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
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $materia_id = $_GET['id'];

    $query = $db->prepare('SELECT * FROM alumno');
    $query->execute();
    $alumnos = $query->fetchAll(PDO::FETCH_ASSOC);


    $db = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar alumnos</title>
</head>
<body>
    <h1>Hola</h1>
    <input type="search" name="" id="search">
    <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Añadir</th>
            </tr>
        <?php foreach ($alumnos as $alumno) { ?>
            <tr>
                    <td class="materis"><?= $alumno['Nombre'] . ' ' . $alumno['Apellidos'] ?></td>
                    <td ><a href="" onclick="<?php alumnoNuevo($alumno) ?>">Añadir</a></td>
            </tr>
        <?php } ?>
    </table>
    <script src="../assets/js/index.js"></script>
</body>
</html>