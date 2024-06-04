<?php
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'ADM') {
        header('Location: ../index.php');
        exit();
    }
    if (isset($_POST['logout'])) {
        require_once('../config/logout.php');
        logout();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/logoSJO-fav.svg">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
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
                <a href="./gestion_materias.php">
                    <img src="../assets/img/layout-grid.svg" alt="Layout icon">
                    Materias
                </a>
            </li>
        </ul>

        <div>
            <div class="user-info-container" id="user-info-container">
                <div class="user-info">
                    <img src="../assets/img/logoSJO.svg" alt="Logo Sant Josep">
                    <p><?php echo $_SESSION['username'] ?></p>
                </div>
                <img src="../assets/img/arrow-select.svg" alt="Vector img" class="vector-img">
            </div>
            <div class="optionsProfile" id="optionsProfile">
                <ul>
                    <li>
                        <a href="./perfil.php">
                            <div style="display: flex;  align-items: center;">
                                <img src="../assets/img/person.svg" alt="" style="margin-right: 6px;">
                                Ver Perfil
                            </div>
                            <img src="../assets/img/chevron-right.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <form action="gestion_users.php" method="post">
                            <button type="submit" name="logout">
                                <div div style="display: flex;  align-items: center;">
                                    <img src="../assets/img/logout.svg" alt="" style="margin-right: 6px;">
                                    Cerrar Sesión
                                </div>
                                <img src="../assets/img/chevron-right.svg" alt="">
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div id="main">
        <div id="content">
            <div id="top-content">
                <ul>
                    <li class="active">
                        <a href="./gestion_users.php">Usuarios</a>
                    </li>
                    <li>
                        <a href="./gestion_alumnos.php">Alumnos</a>
                    </li>
                </ul>
                <a href="./new_user.php" id="button-top">
                    <img src="../assets/img/plus-circled.svg" alt="Pasar Lista">
                    Añadir Usuario
                </a>
            </div>
            <div id="title">
                <h3>Usuarios</h3>
                <p>Busca entre todos los usuarios</p>
            </div>
            <div id="main-content">
                <form action="insert_user.php" method="post">
                    <p>DNI</p>
                    <input type="text" name="dni" value="" maxlength="10">
                    <p>Nombre</p>
                    <input type="text" name="nombre" value="">
                    <p>Apellidos</p>
                    <input type="text" name="apellidos" value="" >
                    <p>Email</p>
                    <input type="email" name="email" value="">
                    <p>Contraseña</p>
                    <input type="text" name="password" value="">
                    <p>Teléfono</p>
                    <input type="number" name="telefono" id="telefono" value="" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9">
                    <p>Rol</p>
                    <div class="form-select">
                        <select name="rol" id="rol_id">
                            <option value="PRO">Profesor</option>
                            <option value="COO">Coordinador</option>
                            <option value="ADM">Administrador</option>
                        </select>
                        <img src="../assets/img/arrow-select.svg" alt="">
                    </div>
                    <input type="submit" value="Confirmar">
                </form>
            </div>
        </div>
    </div>
<div id="mobile-menu">
        <a href="./admin_dashboard.php" class="active">
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./gestion_users.php">
            <img src="../assets/img/Vector.svg" alt="gestion-users-icon">
        </a>
        <a href="./gestion_materias.php">
            <img src="../assets/img/layout-grid.svg" alt="gestion-materias-icon">
        </a>
        <a href="./perfil.php">
            <img src="../assets/img/person.svg" alt="person-icon">
        </a>
        <form action="admin_dashboard.php" method="post">
            <button type="submit" name="logout">
                <img src="../assets/img/logout.svg" alt="logout-icon">
            </button>
        </form>
    </div>
<div id="mobile-menu">
        <a href="./admin_dashboard.php" class="active">
            <img src="../assets/img/icon-home.svg" alt="home-icon">
        </a>
        <a href="./gestion_users.php">
            <img src="../assets/img/Vector.svg" alt="gestion-users-icon">
        </a>
        <a href="./gestion_materias.php">
            <img src="../assets/img/layout-grid.svg" alt="gestion-materias-icon">
        </a>
        <a href="./perfil.php">
            <img src="../assets/img/person.svg" alt="person-icon">
        </a>
        <form action="admin_dashboard.php" method="post">
            <button type="submit" name="logout">
                <img src="../assets/img/logout.svg" alt="logout-icon">
            </button>
        </form>
    </div>
<script src="../assets/js/index.js"></script>
</html>