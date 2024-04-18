<?php
    session_start();
    
    if (isset($_SESSION['email'])) {
        if($_SESSION['rol'] == 'ADM') {
            header('Location: ./admin/admin_dashboard.php');
            exit();
        } elseif($_SESSION['rol'] == 'COO') {
            header('Location: ./coordinador/coordinador_dashboard.php');
            exit();
        } else {
            header('Location: ./profesor/profesor_dashboard.php');
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
                    $ruta = './admin/admin_dashboard.php';
                } elseif ($user['ROL'] == 'COO') {
                    $ruta = "./coordinador/coordinador_dashboard.php";
                } else {
                    $ruta = "./profesor/profesor_dashboard.php";
                }
                header("Location: $ruta");
                exit();
            } else {
                $error = "Email o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            echo "Error de consulta: " . $e->getMessage();
        }
    }
?>
