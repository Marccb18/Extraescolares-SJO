<?php
    require('../config/conexion.php');

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $telefono = $_POST['telefono'];
        $rol = $_POST['rol'];

        try {
            $query = $db->prepare("INSERT INTO personal (DNI, Nombre, Apellidos, Email, Password, Telefono, Rol) VALUES (:dni, :nombre, :apellidos, :email, :password, :telefono, :rol)");
            $query->bindParam(':dni', $user_id);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':apellidos', $apellidos);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);
            $query->bindParam(':telefono', $telefono);
            $query->bindParam(':rol', $rol);
            $query->execute();
            
            $db = null;
            header('Location: gestion_users.php');
            exit();
        } catch (PDOException $e) {
            echo "Error al insertar el registro: " . $e->getMessage();
        }
    }
?>
