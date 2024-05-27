<?php
    require('../config/conexion.php');

    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $telefono = $_POST['telefono'];
        $rol = $_POST['rol'];
        $origin = $_POST['origin'];

        try {
            $query = $db->prepare("UPDATE personal SET Nombre = :nombre, Apellidos = :apellidos, Email = :email, Password = :password, Telefono = :telefono, ROL = :rol WHERE DNI = :user_id");
            
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':apellidos', $apellidos);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);
            $query->bindParam(':telefono', $telefono);
            $query->bindParam(':rol', $rol);
            $query->bindParam(':user_id', $user_id);

            $query->execute();

            $db = null;
            if ($origin == 'edit_user') {
                header('Location: gestion_users.php');
                exit();
            } else {
                header('Location: perfil.php');
                exit();
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $db = null;
        header('Location: gestion_users.php');
        exit();
    }

?>