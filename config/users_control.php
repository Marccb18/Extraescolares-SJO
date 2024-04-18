<?php
    session_start();
    $rutas = array('admin/admin_dashboard.php',
    'coordinador/coordinador_dashboard.php',
    'profesor/profesor_dashboard.php');
    if (isset($_SESSION['email'])) {
        if($_SESSION['rol'] == 'ADM') {
            header("Location: ./$rutas[0]");
            exit();
        } elseif($_SESSION['rol'] == 'COO') {
            header("Location: ./$rutas[1]");
            exit();
        } else {
            header("Location: ./$rutas[2]");
            exit();
        }
    }
    
    $error = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['email'];
        $password = $_POST['password'];
    
        try {
            $statement = $db->prepare("SELECT * FROM personal WHERE Email = :email AND Password = :password");
            $statement->execute(array(':email' => $username, ':password' => $password));
            $user = $statement->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                $_SESSION['email'] = $user['Email'];
                $_SESSION['username'] = $user['Nombre'];
                $_SESSION['rol'] = $user['ROL'];
                if ($user['ROL'] == 'ADM') {
                    $ruta = $rutas[0];
                } elseif ($user['ROL'] == 'COO') {
                    $ruta = $rutas[1];
                } else {
                    $ruta = $rutas[2];
                }
                header("Location: ./$ruta");
                exit();
            } else {
                $error = "Email o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            echo "Error de consulta: " . $e->getMessage();
        }
    }
?>
