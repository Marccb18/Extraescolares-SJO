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
        $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $showUsers = $db->query("SELECT * FROM personal");
    $db = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
    <div id="aside">
        <div id="titlelogo">
            <img src="../assets/img/logoSJO.svg" alt="Logo SJO">
            <p>Sant Josep Obrer</p>
        </div>
        <ul id="side-menu">
            <li>
                <a href="./admin_dashboard.php">
                    <img src="../assets/img/icon-home.svg" alt="Home icon">
                    Inicio
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <img src="../assets/img/Vector.svg" alt="Students icon">
                    Usuarios
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="../assets/img/library.svg" alt="Library icon">
                    Sesiones
                </a>
            </li>
            <li>
                <a href="./gestion_materias.php">
                    <img src="../assets/img/layout-grid.svg" alt="Layout icon">
                    Materias
                </a>
            </li>
        </ul>

        <form action="profesor_dashboard.php" method="post">
            <input type="submit" value="logout" name="logout">
        </form>
        
    </div>
    <div id="main">
        <div id="content">
            <div id="topcontent">
                <div id="title">
                    <h3>Usuarios</h3>
                    <p>Busca entre todas los usuarios<p>
                </div>
                <a href="new_user.php" id="button-top">
                    <img src="../assets/img/plus-circled.svg" alt="Crear Usuario">
                    Crear Usuario
                </a>
            </div>
            <div class="main-content">
                <table border="1">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    <?php foreach ($showUsers as $user) {?>
                        <tr>
                            <td>
                                <img src="../assets/img/user.svg" alt="user">
                                <?= $user['Nombre'] ?>
                            </td>
                            <td><?= $user['Apellidos'] ?></td>
                            <td>
                                <?php
                                    switch ($user['ROL']) {
                                        case 'PRO':
                                            echo 'Profesor';
                                            break;
                                            
                                        case 'COO':
                                            echo 'Coordinador';
                                            break;
                                        
                                        case 'ADM':
                                            echo 'Administrador';
                                            break;
                                    }
                                ?>
                            </td>
                            <td><a href="edit_user.php?id=<?= $user['DNI'] ?>"><img src="../assets/img/pen.svg" alt="">Editar</a></td>
                            <td><a href="delete_user.php?id=<?= $user['DNI'] ?>"><img src="../assets/img/trash.svg" alt="">Eliminar</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>