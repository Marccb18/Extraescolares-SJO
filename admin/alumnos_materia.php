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

    $query = $db->prepare('SELECT * FROM alumno WHERE ID_Materia != :id_materia');
    $query->bindParam(':id_materia', $materia_id);
    $query->execute();
    $alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit_button'])) {
        if (!empty($_POST['selected_alumnos'])) {
            $selectedStudents = $_POST['selected_alumnos'];

            foreach ($selectedStudents as $student) {
                $query = $db->prepare('UPDATE alumno SET ID_Materia = :id_materia WHERE ID = :id');
                $query->bindParam(':id_materia', $materia_id);
                $query->bindParam(':id', $student);
                $query->execute();

                $db = null;
                header('Location: gestion_materias.php');
                exit();
            }
        }
    }

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
    <form method="post">
        <table border="1">
                <tr>
                    <th>Nombre</th>
                    <th>Añadir</th>
                </tr>
            <?php foreach ($alumnos as $alumno) { ?>
                <tr>
                        <td class="materis"><?= $alumno['Nombre'] . ' ' . $alumno['Apellidos'] ?></td>
                        <td><input type="checkbox" name="selected_alumnos[]" value="<?= $alumno['ID'] ?>"></td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" name="submit_button" value="Confirmar">
    </form>
    <script src="../assets/js/index.js"></script>
</body>
</html>